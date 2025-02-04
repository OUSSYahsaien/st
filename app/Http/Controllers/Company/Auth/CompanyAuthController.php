<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Company;
use App\Models\Offers;
use App\Models\TeamMember;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Ajoutez cette ligne correctement
use Illuminate\Support\Facades\DB;

class CompanyAuthController extends Controller
{
    

    public function dashboard(Request $request)
    {
        $companyID = Auth::user()->id;
        $company = Company::findOrFail($companyID);

        // dd($request->all());

        $startDate = $request->start_date ?? Carbon::now()->startOfWeek()->format('Y-m-d');
        $endDate = $request->end_date ?? Carbon::now()->endOfWeek()->format('Y-m-d');


        $period = $request->period ?? 'week';     
        
        

        // Compter les offres publiques
        $publicOffers = DB::table('offers')
            ->join('offer_statuses', 'offers.id', '=', 'offer_statuses.id_offer')
            ->where('offers.id_company', $companyID)
            ->where('offer_statuses.status', 'Publicada')
            ->count();

        // Compter les offres en révision
        $reviewOffers = DB::table('offers')
            ->join('offer_statuses', 'offers.id', '=', 'offer_statuses.id_offer')
            ->where('offers.id_company', $companyID)
            ->where('offer_statuses.status', 'Revision')
            ->count();

        $candidatInterviewedCount = DB::table('offers')
            ->join('applications', 'offers.id', '=', 'applications.id_offer')
            ->where('offers.id_company', $companyID)
            ->where('applications.status', 'Entrevista')
            ->count();

        // Récupérer les 4 dernières candidatures
        $recentApplications = DB::table('applications')
            ->join('offers', 'applications.id_offer', '=', 'offers.id')
            ->where('offers.id_company', $companyID)
            ->orderBy('applications.created_at', 'desc')
            ->limit(4)
            ->get();

        $offersSendedCount = Offers::where('id_company', $companyID)
        ->whereBetween('created_at', [$startDate, $endDate])->count();


        $apps = DB::table('applications')
        ->join('offers', 'applications.id_offer', '=', 'offers.id')
        ->where('offers.id_company', Auth::user()->id)
        ->whereBetween('applications.created_at', [$startDate, $endDate])->count();




        // Récupérer toutes les offres avec leurs dates
        $offersSended = Offers::where('id_company', $companyID)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('created_at')
            ->get();

        // Récupérer toutes les candidatures avec leurs dates
        $appsCount = DB::table('applications')
            ->join('offers', 'applications.id_offer', '=', 'offers.id')
            ->where('offers.id_company', Auth::user()->id)
            ->whereBetween('applications.created_at', [$startDate, $endDate])
            ->select('applications.created_at')
            ->get();
            
        

        return view('Company.dashboard', compact(
            'company',
            'candidatInterviewedCount', 
            'publicOffers', 
            'reviewOffers',
            'recentApplications',
            'offersSended',
            'offersSendedCount',
            'appsCount',
            'apps',
            'startDate',
            'endDate',
            'period'
        ));
    }

    public function showLoginForm()
    {
        return view('company.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('company')->attempt($request->only('email', 'password'))) {
            // Vérifier si le compte est actif
            $company = Auth::guard('company')->user();
            
            if ($company->is_active === 'yes') {
                $request->session()->regenerate();
                return redirect()->route('company.dashboard');
            }
            
            // Si le compte n'est pas actif, déconnecter l'utilisateur
            Auth::guard('company')->logout();
            return back()->withErrors(['email' => 'Su cuenta ha sido desactivada. Por favor, póngase en contacto con el administrador.']);
        }

        return back()->withErrors(['email' => 'Las credenciales son incorrectas.']);
    }

    
    public function showRegisterForm()
    {
        return view('Company.auth.register');
    }

    
    public function register(Request $request)
    {

        $request->validate([
            'fullname' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email|max:255',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|max:255',
        ]);

        $company = Company::create([
            'name' => $request->company,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tel' => $request->phone,
            'poste' => $request->position,
        ]);

        // Créer le premier employé en tant que responsable
        $teamMember = TeamMember::create([
            'company_id' => $company->id,
            'full_name' => $request->fullname,
            'poste' => $request->position,
            'location' => '',
            'email' => $request->email,
            'tel_1' => $request->phone,
            'role' => 'responsable',
        ]);

        Auth::guard('company')->login($company);

        return redirect()->route('company.dashboard')->with('success', 'Inscription réussie.');
    }
    






    
    public function markAsRead($id)
    {
        $updated = Auth::user()
            ->notifications()
            ->where('id', $id)
            ->update(['read_at' => now()]);
    
        return response()->json([
            'success' => $updated > 0,
            'message' => $updated > 0 ? 'Notification mise à jour' : 'Aucune notification trouvée'
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones han sido marcadas como leídas.'
        ]);
    }
    
    
    
    
    
    
    
    
    
    public function logout(Request $request)
    {
        Auth::guard('company')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('company.login');
    }
}
