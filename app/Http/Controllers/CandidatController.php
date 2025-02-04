<?php

namespace App\Http\Controllers;

use App\Models\AboutCandidat;
use App\Models\Administration;
use App\Models\Application;
use App\Models\Candidat;
use App\Models\CandidateLanguage;
use App\Models\CandidatSkills;
use App\Models\CandidatSocialLink;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Language;
use App\Models\NotificationPreference;
use App\Models\OfferCategory;
use App\Models\Offers;
use App\Notifications\RevisionRequestNotification;
use Carbon\Carbon;
use Database\Seeders\OfferCategorySeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CandidatController extends Controller
{
    public function showProfileForm()
    {

           // Récupérer la description depuis la table about_candidats
            $about = AboutCandidat::where('id_candidat', Auth::user()->id)->first();
        
            
             // Récupérer les liens sociaux par type
            $linkedinLink = CandidatSocialLink::where('id_candidat', Auth::user()->id)
            ->where('type', 'LinkedIn')
            ->first();

            $xLink = CandidatSocialLink::where('id_candidat', Auth::user()->id)
                ->where('type', 'X')
                ->first();

            $websiteLink = CandidatSocialLink::where('id_candidat', Auth::user()->id)
                ->where('type', 'Website')
                ->first();


              // Récupérer les langues du candidat
            $languages = CandidateLanguage::where('id_candidat', Auth::user()->id)
            ->pluck('language')
            ->toArray();

            // Convertir les langues en une chaîne de texte séparée par des virgules
            $languagesString = implode(', ', $languages);

            // Récupérer les expériences liées au candidat
            $experiences = Experience::where('id_candidat', Auth::user()->id)->get();

             // Récupérer les éducations liées au candidat
             $educations = Education::where('id_candidat', Auth::user()->id)->get();

               // Récupérer les compétences liées au candidat
            $skills = CandidatSkills::where('id_candidat', Auth::user()->id)->get();
        
            $availableLanguages = Language::pluck('description')->toArray();
                
            return view('candidat.profile', compact('about', 'linkedinLink','availableLanguages', 'xLink', 'websiteLink', 'languagesString', 'experiences', 'educations', 'skills', 'languages'));
    }
    


    public function showOffersForm(Request $request)
    {
        $query = Application::where('id_candidat', Auth::user()->id);
        
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
        $queryForCounts = Application::where('id_candidat', Auth::user()->id)
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
    
        return view('candidat.offers', compact('myApplications', 'statusCounts', 'startDate', 'endDate'));
    }
    
    
    
    
    
    

    public function test()
    {
        // return view('candidat.profile');
        return view('test');
    }
    

    // Méthode pour mettre à jour l'avatar du candidat connecté
    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|string',
        ]);

        $user = Auth::user(); // Candidat connecté

        // Mise à jour de la colonne avatar_path dans la base de données
        $user->avatar_path = $validated['avatar'];
        $user->save();

        return response()->json(['success' => true]);
    }

    public function updateSocialLinks(Request $request)
    {
        // Valider les entrées
        $validated = $request->validate([
            'linkedin' => 'nullable|url',
            'x_handle' => 'nullable|string',
            'website' => 'nullable|url',
        ]);
    
        // Récupérer l'utilisateur connecté
        $userId = Auth::user()->id;
    
        // Mettre à jour ou créer les entrées pour chaque type de lien
        if (!empty($validated['linkedin'])) {
            CandidatSocialLink::updateOrCreate(
                ['id_candidat' => $userId, 'type' => 'LinkedIn'], // Critères
                ['link' => $validated['linkedin']] // Données à mettre à jour
            );
        }
    
        if (!empty($validated['x_handle'])) {
            CandidatSocialLink::updateOrCreate(
                ['id_candidat' => $userId, 'type' => 'X'], // Critères
                ['link' => $validated['x_handle']] // Données à mettre à jour
            );
        }
    
        if (!empty($validated['website'])) {
            CandidatSocialLink::updateOrCreate(
                ['id_candidat' => $userId, 'type' => 'Website'], // Critères
                ['link' => $validated['website']] // Données à mettre à jour
            );
        }
    
        // Retourner une redirection vers la même page avec un message de succès
        return redirect()->back()->with('success', 'Los enlaces sociales se han actualizado correctamente.');

    }
    
    public function addNewSkill(Request $request)
    {
        // Valider l'entrée
        $validated = $request->validate([
            'newSkillInput' => 'required|string|max:255',
        ]);
    
        // Récupérer l'utilisateur connecté
        $userId = Auth::id();
    
        // Créer une nouvelle compétence en utilisant le modèle
        CandidatSkills::create([
            'id_candidat' => $userId,
            'description' => $validated['newSkillInput'],
        ]);
    
        // Rediriger vers la même page avec un message de succès
        return redirect()->back()->with('success', 'La habilidad se ha agregado con éxito.');
    }

    public function editSkill(Request $request)
    {
        // Validation des données
        $request->validate([
            'skill_id' => 'required|integer|exists:candidat_skills,id',
            'skill_name' => 'required|string|max:255',
        ]);

        try {
            // Récupérer la compétence par son ID
            $skill = CandidatSkills::findOrFail($request->input('skill_id'));

            // Mettre à jour le nom de la compétence
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
        // Validation de l'ID de la compétence
        $request->validate([
            'skill_id' => 'required|integer|exists:candidat_skills,id',
        ]);
    
        try {
            // Récupérer la compétence par son ID
            $skill = CandidatSkills::findOrFail(id: $request->input('skill_id'));
    
            // Supprimer la compétence
            $skill->delete();
    
            // Retourner une réponse avec succès
            return redirect()->back()->with('success', 'La habilidad fue eliminada exitosamente.');
        } catch (\Exception $e) {
            // En cas d'erreur, retourner un message d'erreur
            return redirect()->back()->with('error', 'Se produjo un error al eliminar la habilidad.');
        }
    }
    


    public function updateDetails(Request $request)
    {

        // Validation des données
        $validated = $request->validate([
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
        $userId = Auth::user()->id;
    
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



    public function editAbout(Request $request)
    {
        // Récupération de l'utilisateur connecté
        $userId = Auth::user()->id;
    
        // Vérifier si le candidat existe
        $candidate = Candidat::find($userId);
        if (!$candidate) {
            return redirect()->back()->with('error', 'Candidat introuvable.');
        }

        $description = $request->ta_about ? $request->ta_about : "No hay descripción disponible en este momento.";
        
    
        // Mettre à jour ou créer la description dans le modèle AboutCandidat
        AboutCandidat::updateOrCreate(
            ['id_candidat' => $userId], // Critères pour trouver l'entrée existante
            ['description' => $description] // Mise à jour ou création de la description
        );
    
        // Redirection avec un message flash
        return redirect()->back()->with('success', 'La descripción se ha actualizado correctamente.');
    }

    public function addExperience(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
            'work_type' => 'required|string|in:Tiempo completo,Media jornada,Remoto,Híbrido,Jornada intensiva,Otro',
            'description' => 'nullable|string|max:3000',
        ]);
    
        // Si "Hasta la actualidad" est coché
        if ($request->has('current_job')) {
            $validated['end_date'] = null;
        }
    
        // Remplacement pour "Otro"
        if ($validated['work_type'] === 'Otro' && $request->new_work_type) {
            $validated['work_type'] = $request->new_work_type;
        }
    
        // Enregistrement dans la base de données
            Experience::create([
            'id_candidat' => Auth::user()->id ,
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
            'experience_id' => 'required|exists:experiences,id', // Vérifie si l'ID existe dans la table
            'company_name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:begin_date',
            'Ework_type' => 'required|string|in:Tiempo completo,Media jornada,Remoto,Hibrido,Jornada intensiva,Otro',
            'description' => 'nullable|string|max:3000',
            'new_work_type' => 'nullable|string|max:255', // Optionnel pour le cas "Otro"
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
    
    public function uploadCV(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|mimes:pdf', // Fichier PDF obligatoire, max 2 Mo
        ]);

        $user = Auth::user();

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

    public function editCandidatEmail(Request $request)
    {
        $validate =  $request->validate([
            'email' => 'required|email', // Fichier PDF obligatoire, max 2 Mo
        ]);

        $user = Auth::user();

        
        // Mettre à jour la base de données
        $user->email = $validate['email'];  
        $user->save();

        return redirect('candidat/edit/profile?o=t')->with('success', 'Correo electrónico editado exitosamente.');
    }

    public function editCandidatPassword(Request $request)
    {
        // Validation des champs
        $request->validate([
            'old-password' => 'required|min:8',
            'new-password' => 'required|min:8|different:old-password',
        ]);
    
        // Récupération de l'utilisateur actuel
        $user = Auth::user();
    
        // Vérification de l'ancien mot de passe
        if (!Hash::check($request->input('old-password'), $user->password)) {
            return redirect('candidat/edit/profile?o=t')
           ->withErrors(['old-password' => 'La contraseña antigua es incorrecta.']);
        }
    
        // Mise à jour avec le nouveau mot de passe
        $user->password = Hash::make($request->input('new-password'));
        $user->save();
    
        // Redirection avec message de succès
        return redirect('candidat/edit/profile?o=t')
       ->with('success', '¡La contraseña ha sido actualizada con éxito!');
    }
    

    public function updatePreferences(Request $request)
    {
        $candidat = Auth::user();

        // Mettre à jour ou créer les préférences
        $preferences = NotificationPreference::updateOrCreate(
            ['candidat_id' => $candidat->id], // Condition
            [
                'job_opportunities' => $request->input('job_opportunities', 'no'),
                'newsletter' => $request->input('newsletter', 'no'),
                'privacy_consent' => $request->input('privacy_consent', 'no'),
            ]
        );

        return redirect('candidat/edit/profile?o=t')->with('success', 'Preferences actualizadas con éxito');
    }







    
    public function addEducation(Request $request)
    {
        $validated = $request->validate([
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
            'id_candidat' => Auth::user()->id,
            'university_name' => $validated['university_name'],
            'subject' => $validated['titulacion'],
            'begin_date' => $validated['begin_date'],
            'end_date' => $validated['end_date'],
            'description' => $validated['description'],
            'education_logo_path' => $imageName ?? null,
        ]);

        return redirect()->back()->with('success', 'Experiencia añadida exitosamente.');
    }


    // Méthodes du contrôleur
    public function editEducation($id)
    {
        $education = Education::findOrFail($id);
        return response()->json($education);
    }

    public function updateEducation(Request $request)
    {
        $validated = $request->validate([
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
        


    
    public function deleteExperience($id)
    {
        $experience = Experience::findOrFail($id);
        
        $experience->delete();
        
        return response()->json(['success' => true]);
    }
        
        

    public function disactiveCompte(Request $request)
    {
        try {
            $userID = Auth::user()->id;
            $user = Candidat::findOrFail($userID);
            
            $user->is_active = "inactive";
            $user->save();

            Auth::guard('candidat')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect()->route('candidat.login');
        } catch (\Exception $e) {
            return redirect('candidat/edit/profile?o=t')->with('error', 'Une erreur s\'est produite lors de la désactivation du compte.');
        }
    }
    


    public function requestReview(Request $request)
    {
        $appId = $request->input('app_id');
        $application = Application::findOrFail($appId);
        

        $existingRequest = DB::table('notifications')
        ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.application_id')) = ?", [$appId])
        ->whereNull('read_at')
        ->first();

        
        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Una solicitud ya está en proceso'
            ]);
        }

        $admin = Administration::first();
        $admin->notify(new RevisionRequestNotification($application));

        return response()->json([
            'success' => true,
            'message' => 'Solicitud enviada'
        ]);
    }
    
}