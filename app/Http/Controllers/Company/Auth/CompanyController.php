<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\AboutCompany;
use App\Models\Administration;
use App\Models\Company;
use App\Models\CompanyNotificationPreference;
use App\Models\CompanySector;
use App\Models\CompanySocialLinks;
use App\Models\ConfigEquipeMember;
use App\Models\Offers;
use App\Models\TeamMember;
use App\Notifications\RevisionRequestFromCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class CompanyController extends Controller
{
    public function showProfileForm()
    {
        $companyId = Auth::user()->id;
        $aboutCompany = AboutCompany::where('company_id', $companyId)->first();
        $teamMembers = TeamMember::where('company_id', Auth::user()->id)->get();
        $socialLinks = CompanySocialLinks::where('company_id', $companyId)->get();
        $employeeCount = TeamMember::where('company_id', Auth::user()->id)->count();

        $secteurName = null;

        if (Auth::user()->secteur_id) {
            $secteur = CompanySector::find(Auth::user()->secteur_id);
            $secteurName = $secteur ? $secteur->name : null;
        }
        return view('Company.profile', compact('secteurName', 'aboutCompany', 'socialLinks', 'teamMembers', 'employeeCount'));
    }

    
    public function addInEquipe()
    {
        $companyId = Auth::user()->id;
        
        return view('Company.add-equipe', compact('companyId'));
    }

    public function editInEquipe($id)
    {
        $companyId = Auth::user()->id;

        $member = TeamMember::where('id', $id)
            ->where('company_id', $companyId)
            ->firstOrFail();

        $config = ConfigEquipeMember::where('team_member_id', $id)->first();

        $additionalInfo = $config ? $config->additional_info : null;
        $location = $config ? $config->location : null;

        return view('Company.edit-equipe', compact('companyId', 'member', 'additionalInfo', 'location'));
    }

    
    public function editDescription(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
        ]);
    
        $companyId = Auth::user()->id;
    
        AboutCompany::updateOrCreate(
            ['company_id' => $companyId],
            ['description' => $request->description]
        );
    
        // Redirection avec un message de succès
        return redirect()->back()->with('success', 'Descripción actualizada con éxito.');
    }

    
    public function addContact(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'type' => 'required|string|max:255',
            'value' => 'required|string|max:255',
        ]);

        // Obtenir l'ID de l'entreprise connectée
        $companyId = Auth::user()->id;

        // Ajouter ou mettre à jour le lien social
        CompanySocialLinks::updateOrCreate(
            [
                'company_id' => $companyId,
                'type' => $request->type,
            ],
            [
                'value' => $request->value,
            ]
        );

        return redirect()->back()->with('success', 'Contacto social agregado o actualizado con éxito.');
    }

    
    public function updateSocialLinks(Request $request)
    {
        $companyId = Auth::user()->id;

        foreach ($request->links as $type => $value) {
            CompanySocialLinks::updateOrCreate(
                [
                    'company_id' => $companyId,
                    'type' => $type,
                ],
                [
                    'value' => $value,
                ]
            );
        }

        return redirect()->back()->with('success', 'Enlaces sociales actualizados con éxito.');
    }

    
    public function editProfile()
    {
        $companyId = Auth::user()->id;
        $aboutCompany = AboutCompany::where('company_id', $companyId)->first();
        $sectors = CompanySector::all();
        $creationDate = Auth::user()->date_de_fondation;
        $socialLinks = CompanySocialLinks::where('company_id', $companyId)->get();
        $preferences = CompanyNotificationPreference::where('company_id', Auth::user()->id)->first();
        $count = TeamMember::where('company_id', Auth::user()->id)->count();
        $teamMembers = TeamMember::where('company_id', Auth::user()->id)->get();



        if ($creationDate) {
            $selectedDay = $creationDate->format('d');
            $selectedMonth = $creationDate->format('m');
            $selectedYear = $creationDate->format('Y');
        } else {
            $selectedDay = now()->format('d');
            $selectedMonth = now()->format('m');
            $selectedYear = now()->format('Y');
        }

        // Déterminer le nombre de jours dans le mois sélectionné
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
        $daysOptions = range(1, $daysInMonth);

        // Passer les jours disponibles et les mois dans la vue
        $monthsOptions = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        return view('Company.edit-profile', compact(
            'companyId',
            'sectors',
            'selectedDay',
            'selectedMonth',
            'selectedYear',
            'daysOptions',
            'monthsOptions',
            'aboutCompany',
            'socialLinks',
            'preferences',
            'count', 
            'teamMembers', 
        ));
    }



    public function uploadPersonalLogo(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Enregistrer l'image dans le dossier public/images/companies_images
        $image->move(public_path('images/companies_images'), $imageName);

        // Mettre à jour la base de données
        $user->update(['personel_pic' => $imageName]);

        return response()->json(['success' => true, 'image' => $imageName]);
    }
    

    public function removeCity()
    {
        $user = Auth::user();
        $user->city = null;
        $user->save();

        return response()->json(['message' => 'City removed successfully.']);
    }



    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'website' => 'required',
            'employees' => 'required|integer',
            'sector' => 'required|integer',
            'creation_date' => 'required|date',
            'description' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->name = $validatedData['company_name'];
        $user->website = $validatedData['website'];
        $user->city = $request->city ? $request->city : '';
        
        $user->staf_nbr = $validatedData['employees'];
        $user->secteur_id = $validatedData['sector'];
        $user->date_de_fondation = $validatedData['creation_date'];
        $user->save();

        
        $aboutCompany = AboutCompany::where('company_id', $user->id)->first();

        AboutCompany::updateOrCreate(
            ['company_id' => $user->id],
            ['description' => $validatedData['description']]
        );


        return response()->json(['message' => 'Profile updated successfully.'], 200);
    }


    
    public function editCompanyEmail(Request $request)
    {
        $validate =  $request->validate([
            'email' => 'required|email',
        ]);

        $user = Auth::user();

        
        // Mettre à jour la base de données
        $user->email = $validate['email'];  
        $user->save();

        // return redirect('candidat/edit/profile?o=t')->with('success', 'Correo electrónico editado exitosamente.');
        return redirect()->back()->with('success', 'Correo electrónico editado exitosamente.');
    }


    
    public function editCompanyPassword(Request $request)
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
            return redirect()->back()
           ->withErrors(['old-password' => 'La contraseña antigua es incorrecta.']);
        }
    
        // Mise à jour avec le nouveau mot de passe
        $user->password = Hash::make($request->input('new-password'));
        $user->save();
    
        // Redirection avec message de succès
        return redirect()->back()
       ->with('success', '¡La contraseña ha sido actualizada con éxito!');
    }

    public function sendResetLink(Request $request)
    {
        $email = $request->input('email');

        // Vérifier si l'e-mail existe dans la base de données
        $user = Company::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No se encontraron usuarios con este correo electrónico']);
        }

        // Générer un token
        $token = str::random(60);

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

    public function updatePreferences(Request $request)
    {
        $company = Auth::user();

        $preferences = CompanyNotificationPreference::updateOrCreate(
            ['company_id' => $company->id], // Condition
            [
                'first' => $request->input('first', 'no'),
                'second' => $request->input('second', 'no'),
                'third' => $request->input('third', 'no'),
            ]
        );

        return redirect()->back()->with('success', 'Preferences actualizadas con éxito');
    }

    
    
   public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:512',
        ]);

        // Sauvegarder la nouvelle image
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/team_images'), $filename);

        // Retourner le nom de l'image dans la réponse JSON
        return response()->json([
            'success' => true,
            'filename' => $filename,
        ]);
    }

    

    
    public function updateFirstInfos(Request $request)
    {
        $companyId = Auth::user()->id;

        // Validation des données
        $request->validate([
            'unique-full-name' => 'required|string|max:255',
            'unique-phone-1' => 'required|string|max:15',
            'unique-phone-2' => 'nullable|string|max:15',
            'unique-email' => 'required|email|max:255|unique:team_members,email',
            'unique-cargo' => 'required|max:255',
            'job-search' => 'in:active,open',
            'job-search-2' => 'in:active,open',
            'uploaded_profile_picture' => 'nullable|string',
        ]);

        // Insertion dans la table team_members
        $teamMember = TeamMember::create([
            'full_name' => $request->input('unique-full-name'),
            'tel_1' => $request->input('unique-phone-1'),
            'tel_2' => $request->input('unique-phone-2') ?? '',
            'email' => $request->input('unique-email'),
            'poste' => $request->input('unique-cargo'),
            'company_id' => $companyId,
            'location' => $request->input('new-location') ?? (Auth::user()->city ?? ''),
            'personel_pic' => $request->input('uploaded_profile_picture'),
        ]);

        // Gestion de la table config_equipe_members
        $additional_info = $request->input('job-search') === 'active' ? 'Estoy' : 'No estoy';
        $location = $request->input('job-search-2') === 'active' ? 'Trabajo1' : 'Trabajo2';

        ConfigEquipeMember::updateOrCreate(
            ['team_member_id' => $teamMember->id],
            [
                'additional_info' => $additional_info,
                'location' => $location,
            ]
        );

        return redirect('/company/edit-profile?o=t')->with('success', 'Información actualizada exitosamente.');
    }




    public function updateSecondInfos(Request $request, $id)
    {
        $companyId = Auth::user()->id;

        // Validation des données
        $request->validate([
            'unique-full-name' => 'required|string|max:255',
            'unique-phone-1' => 'required|string|max:15',
            'unique-phone-2' => 'nullable|string|max:15',
            'unique-email' => 'required|email|max:255',
            'unique-cargo' => 'required|max:255',
            'job-search' => 'in:active,open',
            'job-search-2' => 'in:active,open',
            'uploaded_profile_picture' => 'nullable|string',
        ]);

        
        // Insertion dans la table team_members
        $teamMember = TeamMember::where('id', $id)
        ->where('company_id', $companyId)
        ->firstOrFail();
    
        // Mise à jour des champs individuellement
        $teamMember->full_name = $request->input('unique-full-name');
        $teamMember->tel_1 = $request->input('unique-phone-1');
        $teamMember->tel_2 = $request->input('unique-phone-2') ?? '';
        $teamMember->email = $request->input('unique-email');
        $teamMember->poste = $request->input('unique-cargo');
        $teamMember->location = $request->input('new-location') ?? (Auth::user()->city ?? '');
        $teamMember->personel_pic = $request->input('uploaded_profile_picture');
        
        // Sauvegarde dans la base de données
        $teamMember->save();
        
    
        // Gestion de la table config_equipe_members
        $additional_info = $request->input('job-search') === 'active' ? 'Estoy' : 'No estoy';
        $location = $request->input('job-search-2') === 'active' ? 'Trabajo1' : 'Trabajo2';

        ConfigEquipeMember::updateOrCreate(
            ['team_member_id' => $teamMember->id],
            [
                'additional_info' => $additional_info,
                'location' => $location,
            ]
        );

        return redirect('/company/edit-profile?o=t')->with('success', 'Información actualizada exitosamente.');
    }

    
    public function disactiveCompte(Request $request)
    {
        try {
            $userID = Auth::user()->id;
            $user = Company::findOrFail($userID);
            
            $user->is_active = "no";
            $user->save();

            Auth::guard('company')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
    
            return redirect()->route('company.login');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la désactivation du compte.');
        }
    }


    

    public function requestReview(Request $request)
    {
        $offerId = $request->input('offer_id');
        $offer = Offers::findOrFail($offerId);

        // Vérifier les notifications existantes
        $existingRequest = DB::table('notifications')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.offer_id')) = ?", [$offerId])
            ->whereNull('read_at')
            ->first();

        if ($existingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'Ya está en trámite una solicitud de revisión.'
            ]);
        }

        // Envoyer la notification aux administrateurs
        $admin = Administration::first();
        $admin->notify(new RevisionRequestFromCompany($offer));


        return response()->json([
            'success' => true,
            'message' => 'Su solicitud de revisión ha sido enviada.'
        ]);
    }
    
    
}
