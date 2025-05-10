<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Password::defaults()],  // password_confirmation
                'role' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Erreur de validation',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->roles()->attach($request->role);

            $token = $user->createToken('auth_token')->accessToken;

            Mail::to($user->email)->send(new VerifyEmail($user));

            return response()->json([
                'status' => true,
                'message' => 'Utilisateur créé avec succès',
                'user' => $user,
                'token' => $token,
                'role' => $request->role
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erreur d\'inscription: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Erreur lors de la création de l\'utilisateur',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Les informations de connexion sont incorrectes.'],
            ]);
        }

        $user = Auth::user();
        $roles = $user->roles;
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'role' => $roles[0]->name
        ], 200);
    }

    /**
     * Redirige l'utilisateur vers Microsoft pour l'authentification.
     */
    public function redirectToMicrosoft()
    {
        return Socialite::driver('microsoft')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Récupère les informations de l'utilisateur après le retour de Microsoft.
     */
    public function handleMicrosoftCallback()
    {
        try {
            $socialUser = Socialite::driver('microsoft')->user();

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'name' => $socialUser->getName() ?? 'Utilisateur Microsoft',
                    'password' => Str::random(24),
                    'email_verified_at' => now(),
                ]
            );

            $token = $user->createToken('microsoftToken')->plainTextToken;

            return $this->successResponse([
                'user' => $user,
                'token' => $token
            ], 'Connexion Microsoft réussie');
        } catch (\Exception $e) {
            Log::error('Microsoft Auth Error: ' . $e->getMessage());
            return $this->errorResponse('Échec de l\'authentification Microsoft', null, 500);
        }
    }

    /**
     * Obtenir les informations de l'utilisateur connecté.
     */
    public function user(Request $request)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Utilisateur authentifié',
                'user' => $request->user()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Déconnexion de l'utilisateur.
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => true,
                'message' => 'Déconnexion réussie'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Une erreur est survenue lors de la déconnexion',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
