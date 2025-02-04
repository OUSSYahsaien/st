<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditProfileController extends Controller
{
    public function showMyprofileForm()
    {
        // Récupérer les préférences associées au candidat connecté
        $preferences = NotificationPreference::where('candidat_id', Auth::user()->id)->first();
    
        return view('candidat.ProfileEditing.myProfile', compact('preferences'));
    }
    
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg', // max 512KB
        ]);

        $user = Auth::user();

        // Supprimer l'ancienne image si elle existe
        if ($user->personal_picture_path && file_exists(public_path('images/candidats_images/' . $user->personal_picture_path))) {
            unlink(public_path('images/candidats_images/' . $user->personal_picture_path));
        }

        // Sauvegarder la nouvelle image
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/candidats_images'), $filename);

        // Mettre à jour le chemin de l'image dans la base de données
        $user->personal_picture_path = $filename;
        $user->save();

        return redirect()->back()->with('success', 'La photo de profil a été mise à jour avec succès.');
    }

    


    public function updateFirstInfos(Request $request)
    {
        // Validation des données
        $request->validate([
            'unique-firstname' => 'required|string|max:255',
            'unique-lastname' => 'required|string|max:255',
            'unique-phone' => 'required|string|max:15',
            'unique-email' => 'required|email|max:255',
            'unique-cargo' => 'required|max:255',
            'unique-location' => 'required|max:255',
            'unique-birthdate' => 'nullable|date',
            'unique-gender' => 'in:male,female',
            'job-search' => 'in:active,open',
        ]);
    
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Mettre à jour les champs
        $user->first_name = $request->input('unique-firstname');
        $user->last_name = $request->input('unique-lastname');
        $user->tel = $request->input('unique-phone');
        $user->email = $request->input('unique-email');
        $user->poste = $request->input('unique-cargo');
        $user->adresse = $request->input('unique-location');
        $user->date_of_birth = $request->input('unique-birthdate');
        $user->gender = $request->input('unique-gender');
        $user->priority = $request->input('job-search') == "open" ? "yes" : "no" ; // Assurez-vous que ce champ existe dans la table.
    
        // Enregistrer les modifications
        $user->save();
    
        return redirect()->back()->with('success', 'Información actualizada exitosamente.');
    }
    


    public function deleteDocument()
    {
        try {
            // Récupérer l'utilisateur connecté
            $user = Auth::user();

            // Chemin du document
            // $documentPath = asset('storage/uploads/candidats_documents/' . $documentName);

            // Vérifier si le fichier existe
            // if (file_exists($documentPath)) {
                // Supprimer le fichier
                // unlink($documentPath);

                // Supprimer l'entrée de la base de données si nécessaire
                $user->cv_file_path = null;
                $user->save();

                return redirect()->back()->with('success', 'El documento ha sido eliminado exitosamente.');
            // } else {
            //     return redirect()->back()->with('error', 'Le document n\'existe pas.');
            // }
        } catch (\Exception $e) {
            // Gérer les erreurs
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du document.');
        }
    }

    

    
}
