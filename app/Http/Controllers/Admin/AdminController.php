<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Candidat;
use App\Models\Company;
use App\Models\Event;
use App\Models\Offers;
use App\Models\OfferStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    public function checkAuth() {
        // Récupérer l'URL de la route précédente
        $previousUrl = URL::previous();
    
        // Trouver la route correspondante
        $previousRoute = app('router')->getRoutes()->match(app('request')->create($previousUrl));
    
        if ($previousRoute) {
            $routeName = $previousRoute->getName(); // Nom de la route précédente
    
            if (Str::startsWith($routeName, 'candidat.')) {
                return redirect('candidat/dashboard');
            } elseif (Str::startsWith($routeName, 'company.')) {
                return redirect('company/dashboard');
            } elseif (Str::startsWith($routeName, 'administration.')) {
                return redirect('administration/dashboard');
            } else {
                return redirect('login');
            }
        } else {
            dd('Impossible de déterminer la route précédente.');
        }
    }

    

    public function showLoginForm()
    {

        return view('Admin.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('administration')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('administration.dashboard');
        }

        return back()->withErrors(['email' => 'Les informations d’identification sont incorrectes.']);
    }

    
    public function dashboard(Request $request)
    {
        $type = $request->input('typeActor', 'candidats');


        $period = $request->input('period', 'week');
        
        
        // Récupérer les dates de filtrage depuis la requête
        $startDate = request('start_date') 
            ? Carbon::parse(request('start_date'))->startOfDay()
            : Carbon::now()->startOfWeek();
        
        $endDate = request('end_date')
            ? Carbon::parse(request('end_date'))->endOfDay()
            : Carbon::now()->endOfWeek();

        // Récupérer les statistiques selon la période
        // $candidateStats = $this->getCandidateStats($startDate, $endDate, $period);
        // $confirmedAppsStats = $this->getConfirmedAppsStats($startDate, $endDate, $period);


        $newCandidates = Candidat::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->get()
        ->pluck('count', 'date');

        $confirmedCandidates = Application::where('status', 'Confirmada')
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->selectRaw('DATE(updated_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->get()
        ->pluck('count', 'date');
        
            
         // Créer un tableau pour tous les jours de la semaine
        $candidateStats = [];
        $confirmedAppsStats = [];

        for($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $candidateStats[$dateStr] = $confirmedCandidates[$dateStr] ?? 0;
            $confirmedAppsStats[$dateStr] = $newCandidates[$dateStr] ?? 0;
        }




        
        $newCompanies = Company::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->get()
        ->pluck('count', 'date');

        $offersRecived = Offers::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupBy('date')
        ->get()
        ->pluck('count', 'date');
        
            
         // Créer un tableau pour tous les jours de la semaine
        $newCompaniesStats = [];
        $offersRecivedStats = [];

        for($date = clone $startDate; $date <= $endDate; $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $newCompaniesStats[$dateStr] = $offersRecived[$dateStr] ?? 0;
            $offersRecivedStats[$dateStr] = $newCompanies[$dateStr] ?? 0;
        }
    
        
            
    
        // Récupérer le nombre de candidats entre les dates avec la colonne created_at
        $nombreCandidats = Candidat::whereBetween('created_at', [$startDate, $endDate])->count();
        $nombreCompany = Company::whereBetween('created_at', [$startDate, $endDate])->count();
        // $nombreCandidatConfermed = Application::whereBetween('created_at', [$startDate, $endDate])->where('status', 'Confirmada')->count();
        
        
        
        
        $nombreCompanies = Company::whereBetween('created_at', [$startDate, $endDate])->count();
        $offerRecived = Offers::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalClients = Company::count();
        $totalOffer = Offers::count();
        
        

        $nombreCandidatConfermed = Application::where('status', 'Confirmada')
        ->whereBetween('updated_at', [$startDate, $endDate])
        ->count();
        

        $tcCount = Offers::where('work_type', 'Tiempo completo')->count();
        $rCount  = Offers::where('work_type', 'Remoto')->count();
        $mjCount = Offers::where('work_type', 'Media jornada')->count();
        $hCount  = Offers::where('work_type', 'Hibrido')->count();
        $jiCount = Offers::where('work_type', 'Jornada intensiva')->count();
        
        $RevisionCount = OfferStatus::where('status', 'Revision')->count();
        $CerradaCount = OfferStatus::where('status', 'Cerrada')->count();
        $PublicadaCount = OfferStatus::where('status', 'Publicada')->count();




        $today = $request->input('today_date');
    
        // Si `today_date` est vide, utilisez la date d'aujourd'hui
        if (empty($today)) {
            $today = now()->format('Y-m-d');
        }
        
        
    
        $events = Event::select(
                    'events.id', 'events.title', 'events.id_candidat', 'events.id_company', 
                    'events.description', 'events.start', 'events.end', 
                    'candidats.first_name as f_name', 'candidats.last_name as l_name', 
                    'candidats.personal_picture_path as candidat_image', 
                    'companies.name as company_name',
                    'companies.personel_pic as company_image'
                )
                ->leftJoin('candidats', 'events.id_candidat', '=', 'candidats.id')
                ->leftJoin('companies', 'events.id_company', '=', 'companies.id')
                ->whereDate('events.start', $today)
                ->orderBy('events.start', 'asc')
                ->get()
                ->map(function ($event) {
                    // Ajouter 1 heure à l'heure de début et de fin
                    $startTime = Carbon::parse($event->start)->addHours(1);
                    $endTime = Carbon::parse($event->end)->addHours(1);

                    // Vérifier si les informations de candidat ou d'entreprise sont présentes
                    $candidat = $event->f_name && $event->l_name ? $event->f_name . " " . $event->l_name : null;
                    $company = $event->company_name ? $event->company_name : null;

                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'description' => $event->description,
                        'start' => $startTime,
                        'end' => $endTime,
                        'candidat' => $candidat,           // Si le candidat existe
                        'company' => $company,             // Si l'entreprise existe
                        'candidat_image' => $event->candidat_image,
                        'company_image' => $event->company_image,
                        'isCandidat' => $event->id_candidat ? 1 : 0,
                        'isCompany' => $event->id_company ? 1 : 0,
                    ];
                });



        
        // dd($type);
    
        return view('Admin.dashboard', compact('totalOffer','newCompaniesStats','offersRecivedStats','offerRecived','totalClients','nombreCompanies','type','candidateStats', 'confirmedAppsStats','tcCount','today','events','rCount','mjCount','hCount','jiCount','nombreCandidats','nombreCompany', 'nombreCandidatConfermed','candidateStats', 'confirmedAppsStats', 'period','startDate', 'endDate', 'RevisionCount', 'CerradaCount','PublicadaCount'));
    }



    private function getCandidateStats($startDate, $endDate, $period)
    {
        $query = Candidat::whereBetween('created_at', [$startDate, $endDate]);

        switch ($period) {
            case 'week':
                // Grouper par jour
                return $query->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [Carbon::parse($item->date)->format('Y-m-d') => $item->count];
                    });

            case 'month':
                // Grouper par semaine
                return $query->selectRaw('YEARWEEK(created_at) as week, COUNT(*) as count')
                    ->groupBy('week')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $weekStart = Carbon::parse($item->week)->startOfWeek()->format('Y-m-d');
                        return [$weekStart => $item->count];
                    });

            case 'year':
                // Grouper par mois
                return $query->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [Carbon::create(null, $item->month)->format('M') => $item->count];
                    });
        }
    }
    



    private function getConfirmedAppsStats($startDate, $endDate, $period)
    {
        $query = Application::where('status', 'Confirmada')
            ->whereBetween('updated_at', [$startDate, $endDate]);

        switch ($period) {
            case 'week':
                return $query->selectRaw('DATE(updated_at) as date, COUNT(*) as count')
                    ->groupBy('date')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [Carbon::parse($item->date)->format('Y-m-d') => $item->count];
                    });

            case 'month':
                return $query->selectRaw('YEARWEEK(updated_at) as week, COUNT(*) as count')
                    ->groupBy('week')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        $weekStart = Carbon::parse($item->week)->startOfWeek()->format('Y-m-d');
                        return [$weekStart => $item->count];
                    });

            case 'year':
                return $query->selectRaw('MONTH(updated_at) as month, COUNT(*) as count')
                    ->groupBy('month')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [Carbon::create(null, $item->month)->format('M') => $item->count];
                    });
        }
    }
    
    
    
    
    

    public function updateEvents(Request $request)
    {
        // Récupérer la date du paramètre today_date
        $today = $request->input('today_date');
        
        // Si `today_date` est vide, utilisez la date d'aujourd'hui
        if (empty($today)) {
            $today = now()->format('Y-m-d');
        }
        
        // Récupérer les événements pour la nouvelle date
        $events = Event::select(
                    'events.id', 'events.title', 'events.id_candidat', 'events.id_company', 
                    'events.description', 'events.start', 'events.end', 
                    'candidats.first_name as f_name', 'candidats.last_name as l_name', 
                    'candidats.personal_picture_path as candidat_image', 
                    'companies.name as company_name',
                    'companies.personel_pic as company_image'
                )
                ->leftJoin('candidats', 'events.id_candidat', '=', 'candidats.id')
                ->leftJoin('companies', 'events.id_company', '=', 'companies.id')
                ->whereDate('events.start', $today)
                ->orderBy('events.start', 'asc')
                ->get()
                ->map(function ($event) {
                    // Ajouter 1 heure à l'heure de début et de fin
                    $startTime = Carbon::parse($event->start)->addHours(1);
                    $endTime = Carbon::parse($event->end)->addHours(1);

                    // Vérifier si les informations de candidat ou d'entreprise sont présentes
                    $candidat = $event->f_name && $event->l_name ? $event->f_name . " " . $event->l_name : null;
                    $company = $event->company_name ? $event->company_name : null;

                    // Calcul de la position et largeur
                    $startPosition = ((($startTime->hour - 8) * 60 + intval($startTime->minute)) / 30) * 100;
                    $duration = $startTime->diffInMinutes($endTime);
                    $width = ($duration / 30) * 100;

                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'description' => $event->description,
                        'start' => $startTime,
                        'end' => $endTime,
                        'candidat' => $candidat,
                        'company' => $company,
                        'candidat_image' => asset('images/candidats_images/'.$event->candidat_image),
                        'company_image' => asset('images/companies_images/'.$event->company_image),
                        'startPosition' => $startPosition,
                        'width' => $width,
                        'isCandidat' => $event->id_candidat ? 1 : 0,
                        'isCompany' => $event->id_company ? 1 : 0,
                        'startTime' => $startTime->format('H:i'),
                        'endTime' => $endTime->format('H:i')
                    ];
                });

        // Format de la date à envoyer au client
        $formattedDate = Carbon::parse($today)->locale('es')->format('l, d \de F');

        return response()->json([
            'newFormattedDate' => $formattedDate,
            'events' => $events
        ]);
    }

    
    
    

    
    public function logout(Request $request)
    {
        Auth::guard('administration')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('administration.login');
    }


    // public function offers()
    // {
    //     $perPage = request('perPage', 10);
    //     $offers = Offers::all()->orderBy('id', 'desc')->paginate($perPage);
        
    //     $offersForMobile = Offers::all()->orderBy('id', 'desc')->get();


    //     return view('Admin.offers',  compact('offers', 'offersForMobile'));
    // }


    public function offers()
    {
        $perPage = request('perPage', 10);

        // Use query builder methods directly
        $offers = Offers::orderBy('id', 'desc')->paginate($perPage);
        $offersForMobile = Offers::orderBy('id', 'desc')->get();

        $offersCount = Offers::all()->count();

        return view('Admin.offers', compact('offers', 'offersForMobile','offersCount'));
    }


    public function allCandidats()
    {
        $candidats = Candidat::orderBy('id', 'desc')->paginate(10);
        $candidatsForMobile = Candidat::orderBy('id', 'desc')->get();
        $CandidatCount = Candidat::count();
        
        $status  = "todo";
    
        return view('Admin.Candidats.candidats', compact('candidats','status', 'candidatsForMobile', 'CandidatCount'));
    }
    

    public function openToOpportunitiesCandidats()
    {
        $candidats = Candidat::orderBy('id', 'desc')->where('priority','yes')->paginate(10);
        $candidatsForMobile = Candidat::orderBy('id', 'desc')->where('priority','yes')->get();
        $CandidatCount = $candidats->count();

        $status  = "open";
    
        return view('Admin.Candidats.candidats', compact('candidats','status', 'candidatsForMobile', 'CandidatCount'));
    }

    public function inProgressCandidats()
    {
        $candidats = Candidat::orderBy('id', 'desc')->where('priority','no')->paginate(10);
        $candidatsForMobile = Candidat::orderBy('id', 'desc')->where('priority','no')->get();
        $CandidatCount = $candidats->count();

        $status  = "process";
    
        return view('Admin.Candidats.candidats', compact('candidats','status', 'candidatsForMobile', 'CandidatCount'));
    }
    
}
