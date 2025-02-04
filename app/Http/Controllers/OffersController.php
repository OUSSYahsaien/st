<?php

namespace App\Http\Controllers;

use App\Models\AboutOffer;
use App\Models\Application;
use App\Models\Category;
use App\Models\OfferBenefit;
use App\Models\OfferResponsibilities;
use Illuminate\Http\Request;
use App\Models\OfferCategory;
use App\Models\OfferKnowledge;
use App\Models\OfferLanguage;
use App\Models\OfferNiceToHave;
use App\Models\Offers;
use App\Models\OfferSkill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffersController extends Controller
{
    public function showSearchOffersForm()
    {
        $categories = Category::all();
        
        $offers = Offers::join('offer_statuses', 'offers.id', '=', 'offer_statuses.id_offer')
                        ->where('offer_statuses.status', '=', 'Publicada')
                        ->orderBy('offers.id', 'desc')
                        ->select('offers.*')
                        ->get();

        return view('candidat.search-offers', compact('categories', 'offers'));
    }
    
    public function showOffer(Request $request)
    {
        $offerId = $request->id;
        $offer = Offers::join('offer_statuses', 'offers.id', '=', 'offer_statuses.id_offer')
            ->where('offers.id', $offerId)
            ->where('offer_statuses.status', 'Publicada')
            ->select('offers.*')
            ->firstOrFail();

        $aboutOffer = AboutOffer::where('offer_id', $offerId)->first();
        $responsibilities = OfferResponsibilities::where('offer_id', $offerId)->get();
        $knowledges = OfferKnowledge::where('offer_id', $offerId)->get();
        $niceToHaves = OfferNiceToHave::where('offer_id', $offerId)->get();
        $benefits = OfferBenefit::where('offer_id', $offerId)->get();

        
        $categories = OfferCategory::where('offer_id', $offerId)->get();

        
        $skills = OfferSkill::where('offer_id', $offerId)->get();
        $languages = OfferLanguage::where('offer_id', $offerId)->get();
        $applicationCount = Application::where('id_offer', $offerId)->count();


        $categoryNames = $categories->pluck('name');

        // Récupérer les offer_ids de toutes les lignes dans offer_categories où la catégorie correspond à l'une des catégories de l'offre actuelle
        // $relatedOfferIds = OfferCategory::whereIn('name', $categoryNames)->pluck('offer_id');

        // Récupérer les offres liées à ces offer_ids
        // $relatedOffers = Offers::where('category', $offer->category)->take(6)->get();;
        
        

        $relatedOffers = Offers::join('offer_statuses', 'offers.id', '=', 'offer_statuses.id_offer')
            ->where('offers.category', $offer->category)
            ->where('offer_statuses.status', 'Publicada')
            ->where('offers.id', '!=', $offer->id)
            ->select('offers.*')
            ->orderBy('offers.created_at', 'desc')
            ->take(6)
            ->get();
        
        

        $application = Application::where('id_candidat', Auth::user()->id)->where('id_offer', $offer->id)->first();
            
        // Passer les données à la vue
        return view('candidat.show-offer', compact('offer', 'aboutOffer', 'applicationCount','application', 'responsibilities', 'knowledges', 'niceToHaves', 'benefits', 'categories', 'skills', 'languages', 'relatedOffers'));
    }
    
   public function filterOffers(Request $request)
    {
        $categories = OfferCategory::all();

        $filters = $request->filters;
        $keyword = $request->keyword;
        $city = $request->city;

        // Initialisation de la requête avec la jointure pour les statuts
        $query = Offers::join('offer_statuses', 'offers.id', '=', 'offer_statuses.id_offer')
                    ->where('offer_statuses.status', '=', 'Publicada')
                    ->select('offers.*');

        // Utiliser un OU logique pour tous les filtres
        $query->where(function ($q) use ($filters, $keyword, $city) {
            // Filtrer par type de travail
            if (in_array('fullTime', $filters)) {
                $q->orWhere('work_type', 'Tiempo completo');
            }
            if (in_array('partTime', $filters)) {
                $q->orWhere('work_type', 'Media jornada');
            }
            if (in_array('remote', $filters)) {
                $q->orWhere('work_type', 'Remoto');
            }
            if (in_array('hybrid', $filters)) {
                $q->orWhere('work_type', 'Hibrido');
            }
            if (in_array('ji', $filters)) {
                $q->orWhere('work_type', 'Jornada intensiva');
            }

            // Filtrer par catégories
            $categories = Category::pluck('name')->toArray();
            foreach ($filters as $filter) {
                if (in_array($filter, $categories)) {
                    $q->orWhere('offers.category', 'LIKE', "%{$filter}%");
                }
            }

            // Filtrer par années d'expérience
            if (in_array('without-experience', $filters)) {
                $q->orWhere('offers.experience_years', 0);
            }
            if (in_array('one-twoo-years', $filters)) {
                $q->orWhereBetween('offers.experience_years', [1, 2]);
            }
            if (in_array('twoo-three-years', $filters)) {
                $q->orWhereBetween('offers.experience_years', [2, 3]);
            }
            if (in_array('three-four-years', $filters)) {
                $q->orWhereBetween('offers.experience_years', [3, 4]);
            }
            if (in_array('more-than-four', $filters)) {
                $q->orWhere('offers.experience_years', '>', 4);
            }

            // Filtrer par salaire
            if (in_array('zero-ten-salary', $filters)) {
                $q->orWhereBetween('offers.starting_salary', [0, 10000]);
            }
            if (in_array('eleven-twenty-five-salary', $filters)) {
                $q->orWhereBetween('offers.starting_salary', [11000, 25000]);
            }
            if (in_array('twenty-sixe-fourty-salary', $filters)) {
                $q->orWhereBetween('offers.starting_salary', [26000, 40000]);
            }
            if (in_array('salary40k', $filters)) {
                $q->orWhere('offers.starting_salary', '>', 40000);
            }

            // Filtrer par titre (mot-clé)
            if (!empty($keyword)) {
                $q->orWhere('offers.title', 'LIKE', "%{$keyword}%");
            }

            // Filtrer par ville
            if (!empty($city)) {
                $q->orWhere('offers.place', 'LIKE', "%{$city}%");
            }
        });

        $offers = $query->get();

        $html = view('partials.offers-list', compact('offers', 'categories'))->render();

        return response()->json(['html' => $html]);
    } 

    
    public function applicationNormale(Request $request)
    {
        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
            'offer_id' => 'required|exists:offers,id',
        ]);

        Application::create([
            'id_offer' => $request->offer_id,
            'id_candidat' => $request->candidat_id,
        ]);

        return back()->with('success', '¡Solicitud enviada con éxito!');
    }


    public function applicationCustom(Request $request)
    {
        $request->validate([
            'candidat_id' => 'required|exists:candidats,id',
            'offer_id' => 'required|exists:offers,id',
            'add_infos' => 'nullable|string|max:3000',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx'
        ]);

        $filePath = null;
        if ($request->hasFile('cv_file')) {
            $fileName = time() . '_' . uniqid() . '.' . $request->cv_file->extension();
            
            $request->cv_file->move(public_path('storage/uploads/application_document'), $fileName);
            
            $filePath = $fileName;
        }


        Application::create([
            'id_offer' => $request->offer_id,
            'id_candidat' => $request->candidat_id,
            'motivation_letter' => $request->add_infos ,
            'cv_name' => $filePath
        ]);

        return back()->with('success', '¡Solicitud enviada con éxito!');
    }
    public function deleteApplication($id)
    {
        try {
            $application = Application::where('id', $id)
                ->where('id_candidat', Auth::user()->id)
                ->first();

            if (!$application) {
                return response()->json([
                    'success' => false,
                    'message' => 'Application not found'
                ], 404);
            }

            $application->delete();

            return response()->json([
                'success' => true,
                'message' => 'Application deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting application'
            ], 500);
        }
    }

}
