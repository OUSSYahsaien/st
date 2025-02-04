<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use App\Models\Candidat;

class PasswordResetController extends Controller
{
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        // Vérifier que le token est valide et non expiré
        $reset = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$reset || now()->diffInMinutes($reset->created_at) > 15) {
            return view('errors.link_expired');
        }

        return view('auth.password_reset_form', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        // Vérifiez le token
        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset || now()->diffInMinutes($reset->created_at) > 15) {
            return redirect()->route('login')->with('error', 'Le lien de réinitialisation a expiré.');
        }

        // Mettre à jour le mot de passe
        DB::table('candidats')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // Supprimer le token de réinitialisation
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }




    public function sendResetLink(Request $request)
    {
        $email = $request->input('email');

        // Vérifier si l'e-mail existe dans la base de données
        $user = Candidat::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Aucun utilisateur trouvé avec cet e-mail']);
        }

        // Générer un token
        $token = Str::random(60);

        // Enregistrer le token dans la table de réinitialisation des mots de passe
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Envoyer l'e-mail avec le token
        Mail::to($email)->send(new ResetPasswordMail($token, $email));

        return back()->with('success', 'Se ha enviado un enlace para restablecer la contraseña a su dirección de correo electrónico.');
    }
    
}
