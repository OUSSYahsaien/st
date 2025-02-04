<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidat;
use App\Models\Company;
use App\Models\Event;
use App\Notifications\EventForCandidat;
use App\Notifications\EventForCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $candidats = Candidat::all();
        $companies = Company::all();
        
        return view('admin.calender.calander', compact('candidats', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'id_candidat' => 'nullable|exists:candidats,id',
            'id_company' => 'nullable|exists:companies,id'
        ]);
    
        try {
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'start' => $request->start,
                'end' => $request->end,
                'id_candidat' => $request->id_candidat,
                'id_company' => $request->id_company
            ]);
        

            if ($request->id_candidat && is_null($request->id_company)) {

                $candidat = Candidat::findOrFail($request->id_candidat);
                $candidat->notify(new EventForCandidat($event->id));

            } elseif (is_null($request->id_candidat) && $request->id_company) {
                
                $company = Company::findOrFail($request->id_company);
                $company->notify(new EventForCompany($event->id));
                
            } elseif ($request->id_candidat && $request->id_company) {
               
                $candidat = Candidat::findOrFail($request->id_candidat);
                $candidat->notify(new EventForCandidat($event->id));

                $company = Company::findOrFail($request->id_company);
                $company->notify(new EventForCompany($event->id));
                
            } else {
                // Cas où aucun ID n'est fourni
                // Exemple: Gérer l'erreur ou loguer un avertissement
                // Log::warning('Événement créé sans candidat ni entreprise');
            }
            // Fin des conditions
            
            return response()->json([
                'success' => true,
                'event' => $event
            ]);
        
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el evento: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getEvents()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'id_candidat' => 'nullable|exists:candidats,id',
            'id_company' => 'nullable|exists:companies,id'
        ]);

        try {
            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'start' => $request->start,
                'end' => $request->end,
                'id_candidat' => $request->id_candidat,
                'id_company' => $request->id_company
            ]);

            return response()->json([
                'success' => true,
                'event' => $event
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el evento: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }
}
