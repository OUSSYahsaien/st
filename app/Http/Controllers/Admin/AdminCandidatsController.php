<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCandidat;
use App\Models\Application;
use App\Models\Candidat;
use App\Models\CandidateLanguage;
use App\Models\CandidatSkills;
use App\Models\CandidatSocialLink;
use App\Models\Education;
use App\Models\Experience;
use App\Models\NotificationPreference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCandidatsController extends Controller
{
    public function viewCandidature($id)
    {          
        $candidat = Candidat::findOrfail($id);


        $about = AboutCandidat::where('id_candidat', $id)->first();
        
            
        $linkedinLink = CandidatSocialLink::where('id_candidat', $id)
            ->where('type', 'LinkedIn')
            ->first();
       
        $xLink = CandidatSocialLink::where('id_candidat', $id)
            ->where('type', 'X')
            ->first();
       
         $websiteLink = CandidatSocialLink::where('id_candidat', $id)
            ->where('type', 'Website')
            ->first();
       
       
        $languages = CandidateLanguage::where('id_candidat', $id)
            ->pluck('language')
            ->toArray();
       
        $languagesString = implode(', ', $languages);
       
        $experiences = Experience::where('id_candidat', $id)->get();
       
        $educations = Education::where('id_candidat', $id)->get();
       
        $skills = CandidatSkills::where('id_candidat', $id)->get();
        
        return view('Admin.Candidats.show-candidat-p1', compact('candidat', 'about', 'linkedinLink', 'xLink', 'websiteLink', 'languagesString', 'experiences', 'educations', 'skills', 'languages'));
    }
    
    public function updateDetails(Request $request)
    {

        // Validation des données
        $validated = $request->validate([
            'id_candidat' => 'required',
            'phone' => [
                'required',
                'regex:/^\+?[0-9]{8,20}$/', // Numéro de téléphone avec optionnellement un "+" et entre 8 et 20 chiffres
            ],
            'languages' => 'required|array|min:1',
            'languages.*' => 'string|max:50',
        ], [
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.regex' => 'Veuillez entrer un numéro de téléphone valide (8 à 20 chiffres).',
            'languages.required' => 'Veuillez sélectionner au moins une langue.',
        ]);
    
        // Mettre à jour le numéro de téléphone du candidat
        $userId = $request->id_candidat;
    
        $candidate = Candidat::where('id', $userId)->first();
        if (!$candidate) {
            return response()->json(['success' => false, 'message' => 'Candidat introuvable.'], 404);
        }
        
        $candidate->tel = $validated['phone'];
        $candidate->save();
    
        // Supprimer les langues existantes de l'utilisateur
        CandidateLanguage::where('id_candidat', $userId)->delete();
    
        // Ajouter les nouvelles langues
        foreach ($validated['languages'] as $language) {
            CandidateLanguage::create([
                'id_candidat' => $userId,
                'language' => $language,
            ]);
        }
    
        // Redirection avec un message flash
        return redirect()->back()->with('success', 'Los detalles se han actualizado correctamente.');
    }


    
    public function updateSocialLinks(Request $request)
    {
        // Valider les entrées
        $validated = $request->validate([
            'id_candidat' => 'required',
            'linkedin' => 'nullable|url',
            'x_handle' => 'nullable|string',
            'website' => 'nullable|url',
        ]);
    
        // Récupérer l'utilisateur connecté
        $userId = $request->id_candidat;
        
    
        if (!empty($validated['linkedin'])) {
            CandidatSocialLink::updateOrCreate(
                ['id_candidat' => $userId, 'type' => 'LinkedIn'],
                ['link' => $validated['linkedin']]
            );
        }
    
        if (!empty($validated['x_handle'])) {
            CandidatSocialLink::updateOrCreate(
                ['id_candidat' => $userId, 'type' => 'X'],
                ['link' => $validated['x_handle']]
            );
        }
    
        if (!empty($validated['website'])) {
            CandidatSocialLink::updateOrCreate(
                ['id_candidat' => $userId, 'type' => 'Website'],
                ['link' => $validated['website']]
            );
        }
    
    
        return redirect()->back()->with('success', 'Los enlaces sociales se han actualizado correctamente.');

    }
    

    
    public function editAbout(Request $request)
    {
        // Récupération de l'utilisateur connecté
        $userId = $request->id_candidat;
    
        // Vérifier si le candidat existe
        $candidate = Candidat::find($userId);
        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidat introuvable.');
        }

        $description = $request->ta_about ? $request->ta_about : "No hay descripción disponible en este momento.";
        
    
        AboutCandidat::updateOrCreate(
            ['id_candidat' => $userId], 
            ['description' => $description]
        );
    
        // Redirection avec un message flash
        return redirect()->back()->with('success', 'La descripción se ha actualizado correctamente.');
    }
    


    
    public function addExperience(Request $request)
    {
        $validated = $request->validate([
            'id_candidat' => 'required',
            'company_name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
            'work_type' => 'required|string|in:Tiempo completo,Media jornada,Remoto,Híbrido,Jornada intensiva,Otro',
            'description' => 'nullable|string|max:3000',
        ]);
    
        if ($request->has('current_job')) {
            $validated['end_date'] = null;
        }
    
        if ($validated['work_type'] === 'Otro' && $request->new_work_type) {
            $validated['work_type'] = $request->new_work_type;
        }
    
            Experience::create([
            'id_candidat' => $validated['id_candidat'] ,
            'company_name' => $validated['company_name'],
            'post' => $validated['post'],
            'location' => $validated['location'],
            'begin_date' => $validated['begin_date'],
            'end_date' => $validated['end_date'],
            'work_type' => $validated['work_type'],
            'description' => $validated['description'],
        ]);
    
        return redirect()->back()->with('success', 'Experiencia añadida exitosamente.');
    }
    

    public function editExperience(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'id_candidat' => 'required',
            'experience_id' => 'required|exists:experiences,id',
            'company_name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
            'Ework_type' => 'required|string|in:Tiempo completo,Media jornada,Remoto,Híbrido,Jornada intensiva,Otro',
            'description' => 'nullable|string|max:3000',
            'new_work_type' => 'nullable|string|max:255',
        ]);
    
        // Trouver l'expérience existante
        $experience = Experience::findOrFail($request->experience_id);
    
        // Si "Hasta la actualidad" est coché, la date de fin devient null
        if ($request->has('current_job')) {
            $validated['end_date'] = null;
        }
    
        // Remplacement pour "Otro" si un nouveau type de travail est fourni
        if ($validated['Ework_type'] === 'Otro' && $request->filled('Enew_work_type')) {
            $validated['Ework_type'] = $request->Enew_work_type;
        }
    
        // Mise à jour de l'expérience avec les données validées
        $experience->update([
            'company_name' => $validated['company_name'],
            'post' => $validated['post'],
            'location' => $validated['location'],
            'begin_date' => $validated['begin_date'],
            'end_date' => $validated['end_date'],
            'work_type' => $validated['Ework_type'],
            'description' => $validated['description'],
        ]);
    
        // Redirection ou retour de réponse après la mise à jour
        return redirect()->back()->with('success', 'La experiencia se ha actualizado correctamente.');
    }
    



    
    
    public function addEducation(Request $request)
    {
        $validated = $request->validate([
            'id_candidat' => 'required',
            'university_name' => 'required|string|max:255',
            'titulacion' => 'required|string|max:255',
            'education_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
            'description' => 'nullable|string|max:3000',
        ]);

        $imagePath = null;
        if ($request->hasFile('education_image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->education_image->extension();
            
            $request->education_image->move(public_path('images/education_logos'), $imageName);
            
            $imagePath = 'images/education_logos/' . $imageName;
        }

        if ($request->has('current_job')) {
            $validated['end_date'] = null;
        }

        Education::create([
            'id_candidat' => $validated['id_candidat'],
            'university_name' => $validated['university_name'],
            'subject' => $validated['titulacion'],
            'begin_date' => $validated['begin_date'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description'],
            'education_logo_path' => $imageName ?? null,
        ]);

        return redirect()->back()->with('success', 'Experiencia añadida exitosamente.');
    }
    


    
    public function editEducation($id)
    {
        $education = Education::findOrFail($id);
        return response()->json($education);
    }




    public function updateEducation(Request $request)
    {
        $validated = $request->validate([
            'id_candidat' => 'required',
            'education_id' => 'required|exists:education,id',
            'university_name' => 'required|string|max:255',
            'titulacion' => 'required|string|max:255',
            'education_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
            'description' => 'nullable|string|max:3000',
        ]);

        $education = Education::findOrFail($request->education_id);

        if ($request->hasFile('education_image')) {
            // Suppression de l'ancienne image si elle existe
            if ($education->education_logo_path) {
                $oldImagePath = public_path('images/education_logos/' . $education->education_logo_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload de la nouvelle image
            $imageName = time() . '_' . uniqid() . '.' . $request->education_image->extension();
            $request->education_image->move(public_path('images/education_logos'), $imageName);
            $education->education_logo_path = $imageName;
        }

        $education->university_name = $validated['university_name'];
        $education->subject = $validated['titulacion'];
        $education->begin_date = $validated['begin_date'];
        $education->end_date = $request->has('current_job') ? null : $validated['end_date'];
        $education->description = $validated['description'];
        $education->save();

        return redirect()->back()->with('success', 'Formación actualizada exitosamente.');
    }
    
    

    
    public function deleteEducation($id)
    {
        $education = Education::findOrFail($id);
        
        // Suppression de l'image si elle existe
        if ($education->education_logo_path) {
            $imagePath = public_path('images/education_logos/' . $education->education_logo_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        $education->delete();
        
        return response()->json(['success' => true]);
    }
        

    public function addNewSkill(Request $request)
    {
        $validated = $request->validate([
            'id_candidat' => 'required',
            'newSkillInput' => 'required|string|max:255',
        ]);
    
        $userId = $validated['id_candidat'];
    
        CandidatSkills::create([
            'id_candidat' => $userId,
            'description' => $validated['newSkillInput'],
        ]);
    
        return redirect()->back()->with('success', 'La habilidad se ha agregado con éxito.');
    }




    public function editSkill(Request $request)
    {
        // Validation des données
        $request->validate([
            'id_candidat' => 'required',
            'skill_id' => 'required|integer|exists:candidat_skills,id',
            'skill_name' => 'required|string|max:255',
        ]);

        try {
            $skill = CandidatSkills::findOrFail($request->input('skill_id'));

            $skill->description = $request->input('skill_name');
            $skill->save();

            // Retourner une réponse avec succès
            return redirect()->back()->with('success', 'La habilidad ha sido cambiada exitosamente.');
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return redirect()->back()->with('error', 'Se produjo un error al editar la habilidad.');
        }
    }
    public function deleteSkill(Request $request)
    {
        $request->validate([
            'skill_id' => 'required|integer|exists:candidat_skills,id',
        ]);
    
        try {
            $skill = CandidatSkills::findOrFail(id: $request->input('skill_id'));
    
            $skill->delete();

            return redirect()->back()->with('success', 'La habilidad fue eliminada exitosamente.');
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return redirect()->back()->with('error', 'Se produjo un error al eliminar la habilidad.');
        }
    }

    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|string',
            'id_candidat' => 'required',
        ]);
        $userID = $validated['id_candidat'];

        $user = Candidat::findOrFail($userID);

        // Mise à jour de la colonne avatar_path dans la base de données
        $user->avatar_path = $validated['avatar'];
        $user->save();

        return response()->json(['success' => true]);
    }


    public function showMyprofileForm($id)
    {
        $candidatID = $id;
        $candidat = Candidat::findOrFail($candidatID);
        $preferences = NotificationPreference::where('candidat_id', $candidatID)->first();
    
        return view('Admin.Candidats.edit-candidat-p1', compact('preferences','candidat'));
    }



    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'id_candidat' => 'required' ,
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg', // max 512KB
        ]);

        $userID = $request->id_candidat;
        $user = Candidat::findOrFail($userID);

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
            'id_candidat' => 'required',
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
        $userID = $request->id_candidat;
        $user = Candidat::findOrFail($userID);
    
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
    

        
    public function uploadCV(Request $request)
    {
        $request->validate([
            'id_candidat' => 'required',
            'cv_file' => 'required|mimes:pdf',
        ]);

        $userID = $request->id_candidat;
        $user = Candidat::findOrFail($userID);

        // Stocker le fichier
        $file = $request->file('cv_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/candidats_documents', $fileName, 'public');

        // Mettre à jour la base de données
        $user->cv_file_path = $fileName;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Fichier téléchargé avec succès.',
            'filePath' => asset('storage/' . $filePath),
            'fileName' => $fileName,
        ]);
    }

    


    public function deleteDocument($id)
    {
        try {

            $userID = $id;
            $user = Candidat::findOrFail($userID);
            
            $user->cv_file_path = null;
            $user->save();

            return redirect()->back()->with('success', 'El documento ha sido eliminado exitosamente.');
        } catch (\Exception $e) {
            // Gérer les erreurs
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la suppression du document.');
        }
    }




    public function editCandidatEmail(Request $request)
    {
        $validate =  $request->validate([
            'id_candidat' => 'required', 
            'email' => 'required|email',
        ]);

        $userID = $request->id_candidat;
        $user = Candidat::findOrFail($userID);

        // Mettre à jour la base de données
        $user->email = $validate['email'];  
        $user->save();

        return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')->with('success', 'Correo electrónico editado exitosamente.');
    }

    public function editCandidatPassword(Request $request)
    {
        // Validation des champs
        $request->validate([
            'id_candidat' => 'required',
            // 'old-password' => 'required|min:8',
            'new-password' => 'required|min:8',
        ]);
    
        // Récupération de l'utilisateur actuel
        $userID = $request->id_candidat;
        $user = Candidat::findOrFail($userID);
    
        // Vérification de l'ancien mot de passe
        // if (!Hash::check($request->input('old-password'), $user->password)) {
        //     return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')
        //    ->withErrors(['old-password' => 'La contraseña antigua es incorrecta.']);
        // }
    
        // Mise à jour avec le nouveau mot de passe
        $user->password = Hash::make($request->input('new-password'));
        $user->save();
    
        // Redirection avec message de succès
        return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')
       ->with('success', '¡La contraseña ha sido actualizada con éxito!');
    }
    

    public function updatePreferences(Request $request)
    {

        $userID = $request->id_candidat;
        $user = Candidat::findOrFail($userID);

        // Mettre à jour ou créer les préférences
        $preferences = NotificationPreference::updateOrCreate(
            ['candidat_id' => $userID],
            [
                'job_opportunities' => $request->input('job_opportunities', 'no'),
                'newsletter' => $request->input('newsletter', 'no'),
                'privacy_consent' => $request->input('privacy_consent', 'no'),
            ]
        );

        return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')->with('success', 'Preferences actualizadas con éxito');
    }

    public function disactiveCompte($id)
    {
        try {
            $userID = $id;
            $user = Candidat::findOrFail($userID);
            
            $user->is_active = "inactive";
            $user->save();

            return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')->with('success', 'La cuenta del candidato se ha desactivado correctamente.');
        } catch (\Exception $e) {
            return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')->with('error', 'Une erreur s\'est produite lors de la désactivation du compte.');
        }
    }
    
    
    public function activeCompte($id)
    {
        try {
            $userID = $id;
            $user = Candidat::findOrFail($userID);
            
            $user->is_active = "active";
            $user->save();

            return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')->with('success', 'La cuenta del candidato ha sido activada exitosamente.');
        } catch (\Exception $e) {
            return redirect('administration/candidats/edit/profile/' . $userID . '?o=t')->with('error', 'Se produce un error al activar la cuenta.');
        }
    }

    public function viewCandidatApps(Request $request, $id)
    {
        $candidatID = $id;
        $candidat = Candidat::findOrFail($candidatID);
        
        $query = Application::where('id_candidat', $candidatID);
        
        $startDate = $request->start_date ?? Carbon::now()->startOfWeek()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfWeek()->format('Y-m-d');
        
        if ($request->has('status') && $request->status !== 'todo') {
            $status = ucfirst($request->status);
            $query->where('status', $status);
        }
        
        $query->whereDate('created_at', '>=', $startDate)
              ->whereDate('created_at', '<=', $endDate);
        
        // Créer $myApplications après avoir appliqué tous les filtres
        $myApplications = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        
        // Calculer les compteurs avec le même filtre de date
        $queryForCounts = Application::where('id_candidat', $candidatID)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
        
        $statusCounts = [
            'total' => $queryForCounts->count(),
            'evaluacion' => $queryForCounts->where('status', 'Evaluacion')->count(),
            'proceso' => $queryForCounts->where('status', 'En proceso')->count(),
            'entrevista' => $queryForCounts->where('status', 'Entrevista')->count(),
            'confirmada' => $queryForCounts->where('status', 'Confirmada')->count(),
            'descartada' => $queryForCounts->where('status', 'Descartado')->count(),
        ];
    
        return view('admin.candidats.offers', compact('myApplications', 'statusCounts', 'startDate', 'endDate', 'candidat'));
    }

    
}

