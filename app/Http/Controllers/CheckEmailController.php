<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Message;
use Illuminate\Support\Facades\Log;

class CheckEmailController extends Controller
{
    public function authorizeUser()
    {
        $clientId = env('OUTLOOK_CLIENT_ID');
        $redirectUri = env('OUTLOOK_REDIRECT_URI');
        $scopes = 'openid profile offline_access user.read mail.read';

        $url = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize?" . http_build_query([
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'response_mode' => 'query',
            'scope' => $scopes,
            'state' => csrf_token(),
        ]);

        return redirect($url);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->get('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code is missing.'], 400);
        }

        $clientId = env('OUTLOOK_CLIENT_ID');
        $clientSecret = env('OUTLOOK_CLIENT_SECRET');
        $redirectUri = env('OUTLOOK_REDIRECT_URI');

        $tokenUrl = "https://login.microsoftonline.com/common/oauth2/v2.0/token";

        $response = Http::asForm()->post($tokenUrl, [
            'client_id' => $clientId,
            'scope' => 'openid profile offline_access user.read mail.read',
            'code' => $code,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
            'client_secret' => $clientSecret,
        ]);

        if ($response->successful()) {
            $tokens = $response->json();

            DB::table('oauth_tokens')->updateOrInsert(
                ['user_id' => auth()->id()],
                [
                    'access_token' => $tokens['access_token'],
                    'refresh_token' => $tokens['refresh_token'] ?? null,
                    'expires_at' => now()->addSeconds($tokens['expires_in']),
                ]
            );

            return response()->json(['message' => 'Authorization successful.'], 200);
        }

        return response()->json(['error' => 'Unable to authorize user'], 400);
    }

    private function refreshAccessToken($userId)
    {
        $tokenData = DB::table('oauth_tokens')->where('user_id', $userId)->first();

        if (!$tokenData || empty($tokenData->refresh_token)) {
            return null;
        }

        $response = Http::asForm()->post("https://login.microsoftonline.com/common/oauth2/v2.0/token", [
            'client_id' => env('OUTLOOK_CLIENT_ID'),
            'client_secret' => env('OUTLOOK_CLIENT_SECRET'),
            'refresh_token' => $tokenData->refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->successful()) {
            $tokens = $response->json();

            DB::table('oauth_tokens')->where('user_id', $userId)->update([
                'access_token' => $tokens['access_token'],
                'expires_at' => now()->addSeconds($tokens['expires_in']),
                'refresh_token' => $tokens['refresh_token'] ?? $tokenData->refresh_token,
            ]);

            return $tokens['access_token'];
        }

        return null;
    }

    public function fetchEmails(Request $request)
    {
        $userId = auth()->id();
        $tokenData = DB::table('oauth_tokens')->where('user_id', $userId)->first();

        if (!$tokenData || now()->greaterThan($tokenData->expires_at)) {
            $newAccessToken = $this->refreshAccessToken($userId);
            if (!$newAccessToken) {
                return response()->json(['error' => 'Token expired. Please authorize again.'], 401);
            }
            $tokenData->access_token = $newAccessToken;
        }

        $graph = new Graph();
        $graph->setAccessToken($tokenData->access_token);

        try {
            $pageSize = $request->get('page_size', 10); 
            $page = $request->get('page', 1);

            $messages = $graph->createRequest("GET", "/me/messages?\$top=$pageSize&\$skip=" . ($page - 1) * $pageSize)
                ->setReturnType(Message::class)
                ->execute();

            $emailList = [];

            foreach ($messages as $message) {
                $emailList[] = [
                    'subject' => $message->getSubject(),
                    'sender' => $message->getSender()->getEmailAddress()->getAddress(),
                    'received_date' => $message->getReceivedDateTime(),
                ];
            }

            return response()->json(['emails' => $emailList], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching emails: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch emails'], 500);
        }
    }
}