<?php

namespace App\Http\Controllers;

use App\Models\User;

class VerificationController extends Controller
{
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        if (sha1($user->email) === $hash) {
            // L'e-mail est vérifié
            $user->email_verified_at = now();
            $user->save();

            return redirect()->route('login')->with('status', 'Votre adresse e-mail a été vérifiée avec succès.');
        }

        return redirect()->route('login')->withErrors(['email' => 'Le lien de vérification est invalide.']);
    }
}
