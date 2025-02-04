<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Candidat;
use App\Models\Company;
use App\Models\Event;
use App\Models\Administration;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class CandidatAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('candidat.auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('candidat')->attempt($request->only('email', 'password'))) {
            // Vérifier si le compte est actif
            $candidat = Auth::guard('candidat')->user();
            
            if ($candidat->is_active === 'active') {
                $request->session()->regenerate();
                return redirect()->route('candidat.dashboard');
            }
            
            // Si le compte n'est pas actif, déconnecter l'utilisateur
            Auth::guard('candidat')->logout();
            return back()->withErrors(['email' => 'Su cuenta ha sido desactivada. Por favor, póngase en contacto con el administrador.']);
        }

        return back()->withErrors(['email' => 'Las credenciales son incorrectas.']);
    }
    

    public function showRegisterForm()
    {
        return view('candidat.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidats',
            'password' => 'required|confirmed|min:8',
            'tel' => 'required',
            'position' => 'required'
        ]);

        $candidat = Candidat::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tel' => $request->tel,
            'poste' => $request->position 
        ]);

        Auth::guard('candidat')->login($candidat);

        return redirect()->route('candidat.dashboard');
    }


    public function dashboard()
    {
        $userID = Auth::user()->id;
        
        // Récupérer les dates de filtrage depuis la requête ou utiliser la semaine courante
        $startDate = request('start_date') 
            ? Carbon::parse(request('start_date'))->startOfDay()
            : Carbon::now()->startOfWeek();
        
        $endDate = request('end_date')
            ? Carbon::parse(request('end_date'))->endOfDay()
            : Carbon::now()->endOfWeek();

        // Query de base avec le filtrage par dates
        $baseQuery = Application::where('id_candidat', $userID)
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Total des candidatures avec filtrage par dates
        $applicationsCount = $baseQuery->count();

        // Total des candidatures en statut 'Entrevista' avec filtrage par dates
        $interviewedApplicationsCount = $baseQuery->where('status', 'Entrevista')->count();

        // Calcul des pourcentages
        $interviewedPercentage = $applicationsCount > 0 
            ? round(($interviewedApplicationsCount / $applicationsCount) * 100, 2) 
            : 0;

        $notMatchingPercentage = $applicationsCount > 0 
            ? round((($applicationsCount - $interviewedApplicationsCount) / $applicationsCount) * 100, 2) 
            : 0;

        // Récupérer les 3 dernières candidatures avec filtrage par dates
        $recentApplications = Application::where('id_candidat', $userID)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Ajouter les informations des offres et des entreprises
        $applicationsWithDetails = $recentApplications->map(function ($application) {
            $offer = Offers::find($application->id_offer);
            $company = $offer ? Company::find($offer->id_company) : null;

            return [
                'application' => $application,
                'offer' => $offer,
                'company' => $company,
            ];
        });


        // $today = Carbon::today();


        if (request('currentDate')) {
            $today = Carbon::createFromFormat('Y-m-d', request('currentDate'));
        } else {
            $today = Carbon::today();
        }
    
        $events = Event::where('id_candidat', Auth::user()->id)
            ->whereDate('start', $today)
            ->orderBy('start', 'asc')
            ->get()
            ->map(function ($event) {
                $event->start = Carbon::parse($event->start)->addHour();
                $event->end = Carbon::parse($event->end)->addHour();
                return $event;
            });

        $admin = Administration::first();
            

        // Passer les données à la vue
        return view('candidat.dashboard', compact(
            'applicationsCount',
            'recentApplications',
            'applicationsWithDetails', 
            'interviewedApplicationsCount', 
            'interviewedPercentage', 
            'notMatchingPercentage',
            'startDate',
            'endDate',
            'events',
            'admin',
            'today'
        ));
    }
    
    

    public function updateSchedule(Request $request)
    {
        $today = $request->action ?? Carbon::today();

        // Modifier la date selon l'action
        if ($request->action === 'prev') {
            $today = $today->subDay();
        } elseif ($request->action === 'next') {
            $today = $today->addDay();
        }

        // Récupérer les événements pour la nouvelle date
        $events = Event::where('id_candidat', Auth::user()->id)
            ->whereDate('start', $today)
            ->orderBy('start', 'asc')
            ->get()
            ->map(function ($event) {
                return [
                    'start_formatted' => Carbon::parse($event->start)->format('h:i A'),
                    'title' => $event->title,
                    'admin_username' => $event->admin->username ?? 'N/A',
                    'duration' => number_format(Carbon::parse($event->start)->diffInHours(Carbon::parse($event->end)), 2),
                ];
            });

        return response()->json([
            'date' => $today->isoFormat('D [de] MMMM'),
            'da' => $today->format('Y-m-d'),
            'events' => $events,
        ]);
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
        Auth::guard('candidat')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('candidat.login');
    }
}
