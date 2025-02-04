<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutCandidat;
use App\Models\AboutCompany;
use App\Models\AboutTeamMember;
use App\Models\AcceptedApp;
use App\Models\Application;
use App\Models\Company;
use App\Models\Candidat;
use App\Models\CandidateLanguage;
use App\Models\CandidatSkills;
use App\Models\CandidatSocialLink;
use App\Models\CompanyNotificationPreference;
use App\Models\CompanySector;
use App\Models\CompanySocialLinks;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Offers;
use App\Models\TeamMember;
use App\Models\TeamMemberSocialLinks;
use App\Notifications\ApplicationStatusUpdated;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminCompaniesController extends Controller
{

    public function allCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->paginate(10);
        $companiesForMobile = Company::orderBy('id', 'desc')->get();
        $companyCount = Company::count();
        
        $status  = "todo";
    
        return view('admin.companies.companies', compact('companies','status', 'companiesForMobile', 'companyCount'));
    }
    
    public function newCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->where('status','Nueva')->paginate(10);
        $companiesForMobile = Company::orderBy('id', 'desc')->where('status','Nueva')->get();
        $companyCount = $companies->count();

        $status  = "open";
    
        return view('admin.companies.companies', compact('companies','status', 'companiesForMobile', 'companyCount'));
    }

    public function inProgressCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->where('status','En proceso')->paginate(10);
        $companiesForMobile = Company::orderBy('id', 'desc')->where('status','En proceso')->get();
        $companyCount = $companies->count();

        $status  = "process";
    
        return view('admin.companies.companies', compact('companies','status', 'companiesForMobile', 'companyCount'));
    }

    public function homoCompanies()
    {
        $companies = Company::orderBy('id', 'desc')->where('status','Homologada')->paginate(10);
        $companiesForMobile = Company::orderBy('id', 'desc')->where('status','Homologada')->get();
        $companyCount = $companies->count();

        $status  = "homo";
    
        return view('admin.companies.companies', compact('companies','status', 'companiesForMobile', 'companyCount'));
    }

    public function profileCompany($id)
    {
        $companyId = $id;
        $company = Company::findOrFail($companyId);
        $aboutCompany = AboutCompany::where('company_id', $companyId)->first();
        $teamMembers = TeamMember::where('company_id', $companyId)->get();
        $socialLinks = CompanySocialLinks::where('company_id', $companyId)->get();
        $employeeCount = TeamMember::where('company_id', $companyId)->count();

        $secteurName = null;

        if ($company->secteur_id) {
            $secteur = CompanySector::find($company->secteur_id);
            $secteurName = $secteur ? $secteur->name : null;
        }
        $status = "todo";
        return view('admin.companies.profile', compact('secteurName','status','company', 'aboutCompany', 'socialLinks', 'teamMembers', 'employeeCount'));
    }
    


    
    public function editProfileCompany($id)
    {
        $companyId = $id;
        $company = Company::findOrFail($companyId);

        $aboutCompany = AboutCompany::where('company_id', $companyId)->first();
        $sectors = CompanySector::all();
        $creationDate = $company->date_de_fondation;
        $socialLinks = CompanySocialLinks::where('company_id', $companyId)->get();
        $preferences = CompanyNotificationPreference::where('company_id', $company->id)->first();
        $count = TeamMember::where('company_id', $company->id)->count();
        $teamMembers = TeamMember::where('company_id', $company->id)->get();



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

        return view('admin.companies.edit-profile', compact(
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
            'company'
        ));
    }

    public function editCompanyEmail(Request $request)
    {
        $validate =  $request->validate([
            'id_company' => 'required', 
            'email' => 'required|email',
        ]);

        $userID = $request->id_company;
        $user = Company::findOrFail($userID);

        // Mettre à jour la base de données
        $user->email = $validate['email'];  
        $user->save();

        return redirect()->back()->with('success', 'Correo electrónico editado exitosamente.');
    }


    public function disactiveCompte($id)
    {
        try {
            $userID = $id;
            $user = Company::findOrFail($userID);
            
            $user->is_active = "no";
            $user->save();

            return redirect()->back()->with('success','La cuenta de esta empresa se ha desactivado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la désactivation du compte.');
        }
    }


    public function activeCompte($id)
    {
        try {
            $userID = $id;
            $user = Company::findOrFail($userID);
            
            $user->is_active = "yes";
            $user->save();

            return redirect()->back()->with('success','La cuenta de esta empresa se ha activado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Se produce un error al activar la cuenta.');
        }
    }

    public function editCandidatPassword(Request $request)
    {
        $request->validate([
            'id_company' => 'required',
            'new-password' => 'required|min:8',
        ]);
    
        $userID = $request->id_company;
        $user = Company::findOrFail($userID);
    
    
        // Mise à jour avec le nouveau mot de passe
        $user->password = Hash::make($request->input('new-password'));
        $user->save();
    
        // Redirection avec message de succès
        return redirect()->back()
       ->with('success', '¡La contraseña ha sido actualizada con éxito!');
    }
    
    
    public function offersCompany($id)
    {
        $companyId = $id;
        $company = Company::findOrFail($companyId);


        $perPage = request('perPage', 20);
        
        // Construction de la requête de base
        $query = Offers::where('id_company', $companyId)
            ->orderBy('id', 'desc');

        $offers = $query->clone()->paginate($perPage);
        // Récupérer toutes les offres pour la vue mobile
        $offersForMobile = $query->clone()->get();

        return view('Admin.companies.publicated-offers', compact('company','offersForMobile', 'offers'));
    }


    public function viewApplications($id)
    {  
        $offer = Offers::findOrFail($id);
        $company = Company::findOrFail($offer->id_company);

        $perPage = request('perPage', 10);
        $applicationsCount = Application::where('id_offer', $id)->count();
        
        $applications = Application::where('id_offer', $id)->orderBy('id', 'desc')->paginate($perPage);
        $applicationsForMobile = Application::where('id_offer', $id)->orderBy('id', 'desc')->get();

        
        return view('Admin.companies.offer_application', compact('offer', 'applicationsCount', 'applications', 'applicationsForMobile','company'));
    }

    public function viewApplicationsPipeline($id)
    {  
        $offer = Offers::findOrFail($id);
        $applicationsCount = Application::where('id_offer', $id)->count();

        $applications = Application::where('id_offer', $id)
            ->join('candidats', 'applications.id_candidat', '=', 'candidats.id')
            ->select('applications.*', 'candidats.first_name', 'candidats.last_name', 'candidats.personal_picture_path','candidats.rating')
            ->orderBy('applications.id', 'desc')
            ->get();

        // Ensure status is set, default to 'applied' if not
        $applications = $applications->map(function ($application) {
            $application->status = $application->status ?? 'Evaluacion';
            return $application;
        });

        return view('Admin.companies.offer_applicationPipeline', compact('offer', 'applicationsCount', 'applications'));
    }
    
    public function updateApplicationStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
    
        $oldStatus = $application->status;
        $newStatus = $request->input('status');
    
        if ($oldStatus == $newStatus) {
            return response()->json(['success' => false, 'message' => 'No change in status.']);
        }
    
        // Mettre à jour le statut de l'application
        $application->status = $newStatus;
        $application->save();
    
        // Récupérer l'offre associée
        $offer = Offers::findOrFail($application->id_offer);

        $candidat = Candidat::findOrFail($application->id_candidat);
        $candidat->notify(new ApplicationStatusUpdated($application->id, $oldStatus, $newStatus));
        
        
    
        // Modifier la valeur de nbr_candidat_confermed en fonction des règles
        if ($oldStatus == 'Confirmada') {
            $offer->nbr_candidat_confermed -= 1; // Décrémenter si l'ancien statut était Confirmada
        }
    
        if ($newStatus == 'Confirmada') {
            $offer->nbr_candidat_confermed += 1; // Incrémenter si le nouveau statut est Confirmada


                // Gérer l'enregistrement dans accepted_apps
                $acceptedApp = AcceptedApp::where('app_id', $application->id)->first();
                
                if ($acceptedApp) {
                    $acceptedApp->touch();
                } else {
                    AcceptedApp::create([
                        'app_id' => $application->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
        }
    
        // Sauvegarder les modifications sur l'offre
        $offer->save();
    
        return response()->json(['success' => true]);
    }
    

    public function viewApplication($id)
    {          

        $application = Application::findOrfail($id);
        
        $candidatID = $application->id_candidat;
        $candidat = Candidat::findOrfail($candidatID);


        $about = AboutCandidat::where('id_candidat', $candidatID)->first();
        
            
        $linkedinLink = CandidatSocialLink::where('id_candidat', $candidatID)
            ->where('type', 'LinkedIn')
            ->first();
       
        $xLink = CandidatSocialLink::where('id_candidat', $candidatID)
            ->where('type', 'X')
            ->first();
       
         $websiteLink = CandidatSocialLink::where('id_candidat', $candidatID)
            ->where('type', 'Website')
            ->first();
       
       
        $languages = CandidateLanguage::where('id_candidat', $candidatID)
            ->pluck('language')
            ->toArray();
       
        $languagesString = implode(', ', $languages);
       
        $experiences = Experience::where('id_candidat', $candidatID)->get();
       
        $educations = Education::where('id_candidat', $candidatID)->get();
       
        $skills = CandidatSkills::where('id_candidat', $candidatID)->get();
        

        return view('Admin.companies.show-application', compact('candidat','application', 'about', 'linkedinLink', 'xLink', 'websiteLink', 'languagesString', 'experiences', 'educations', 'skills', 'languages'));
    }
    

    public function updateCandidatRating(Request $request)
    {
        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
            'rating' => 'required|between:0,5',
        ]);

        $candidat = Candidat::findOrFail($request->candidat_id);
        $candidat->rating = $request->rating;
        $candidat->save();
    
        return response()->json(['success' => true]);
    }
    

    public function viewTeamMember($id)
    {
        $teamMember = TeamMember::where('id', $id)
        ->whereNotNull('full_name')
        ->firstOrFail();

        $company = Company::findOrfail($teamMember->company_id);

        $aboutTeamMember = AboutTeamMember::where('member_id', $id)->first();
        $socialLinks = TeamMemberSocialLinks::where('member_id', $id)->get();
    
        // Initialiser les variables pour chaque type de lien
        $linkedin = $socialLinks->firstWhere('type', 'linkedin');
        $xLink = $socialLinks->firstWhere('type', 'x');
        $website = $socialLinks->firstWhere('type', 'website');

        return view('Admin.companies.view-teamMember', compact('linkedin','company', 'xLink', 'website', 'teamMember', 'aboutTeamMember', 'socialLinks'));
    }

    
}
