<?php

namespace App\Http\Controllers;

use App\Models\AboutCandidat;
use App\Models\AboutOffer;
use App\Models\Application;
use App\Models\Candidat;
use App\Models\CandidateLanguage;
use App\Models\CandidatSkills;
use App\Models\CandidatSocialLink;
use App\Models\Category;
use App\Models\Education;
use App\Models\Experience;
use App\Models\OfferBenefit;
use App\Models\OfferCategory;
use App\Models\OfferKnowledge;
use App\Models\OfferLanguage;
use App\Models\OfferNiceToHave;
use App\Models\OfferResponsibilities;
use App\Models\Offers;
use App\Models\OfferSkill;
use App\Models\OfferStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CompanyOffersController extends Controller
{
    // public function myOffers()
    // {
    //     $perPage = request('perPage', 10);
    //     $offers = Offers::where('id_company', Auth::user()->id)->orderBy('id', 'desc')->paginate($perPage);
        
    //     $offersForMobile = Offers::where('id_company', Auth::user()->id)->orderBy('id', 'desc')->get();

    //     return view('Company.Offers.my-offers', compact('offers', 'offersForMobile'));
    // }


    public function myOffers()
    {
        $perPage = request('perPage', 10);
        
        // Récupérer les dates de filtrage depuis la requête
        $startDate = request('start_date') 
            ? Carbon::parse(request('start_date'))->startOfDay()
            : Carbon::now()->startOfWeek();
        
        $endDate = request('end_date')
            ? Carbon::parse(request('end_date'))->endOfDay()
            : Carbon::now()->endOfWeek();
    
        // Construction de la requête de base
        $query = Offers::where('id_company', Auth::user()->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('id', 'desc');
    
        // Récupérer les offres paginées pour la vue desktop
        $offers = $query->clone()->paginate($perPage);
        
        // Récupérer toutes les offres pour la vue mobile
        $offersForMobile = $query->clone()->get();
    
        return view('Company.Offers.my-offers', compact('offers', 'offersForMobile', 'startDate', 'endDate'));
    }
    
    public function dispStepOne()
    {
        $categories = Category::all();

        return view('Company.Offers.add-offer.step-1', compact('categories'));
    }

    
    public function postStepone(Request $request)
    {
        
        $request->validate([
            'jobTitle' => 'required|string|max:255',
            'candidates' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'jobType' => 'required|string|in:Tiempo completo,Media jornada,Remoto,Hibrido,Jornada intensiva',
            's1-minSalary' => 'required|numeric|min:0',
            's1-maxSalary' => 'required|numeric|min:0|gte:s1-minSalary',
            'job_category' => 'required|exists:categories,name',
            'skills' => 'required|array|min:1',
            'skills.*' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
        ]);
        
        
        $offer = DB::table('offers')->insertGetId([
            'title' => $request->jobTitle,
            'nbr_candidat_max' => $request->candidates,
            'place' => $request->location,
            'work_type' => $request->jobType,
            'starting_salary' => $request->input('s1-minSalary'),
            'final_salary' => $request->input('s1-maxSalary'),
            'experience_years' => $request->input('s1-experience-years') ?? 0,
            'category' => $request->job_category,
            'postulation_deadline' => $request->deadline,
            'id_company' => Auth::user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        foreach ($request->skills as $skill) {
            DB::table('offer_skills')->insert([
                'offer_id' => $offer,
                'skill_name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $offerStatusId = DB::table('offer_statuses')->insertGetId([
            'id_offer' => $offer,
            'status' => 'Revision',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect('/company/offers/step-2');
    }
    
    public function dispStepTwoo()
    {
        if (url()->previous() !== url('/company/offers/step-1')) {
            return redirect('/company/myOffers');
        }


        return view('Company.Offers.add-offer.step-2');
    }


    

    public function postStepTwoo(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:5000',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string|max:255', 
            'knowledges' => 'nullable|array', 
            'knowledges.*' => 'string|max:255',
            'se-valora' => 'nullable|array',
            'se-valora.*' => 'string|max:255',
        ]);
        
        $lastOfferId = Offers::latest('id')->value('id');

        if (!$lastOfferId) {
            return redirect()->back()->withErrors(['error' => 'No se encuentra ninguna oferta.']);
        }

        if ($request->filled('description')) {
            AboutOffer::create([
                'offer_id' => $lastOfferId,
                'description' => $request->input('description'),
            ]);
        }
        
        // Insérer les responsabilités si elles existent
        if ($request->filled('responsibilities')) {
            foreach ($request->input('responsibilities') as $responsibility) {
                OfferResponsibilities::create([
                    'offer_id' => $lastOfferId,
                    'responsibility' => $responsibility,
                ]);
            }
        }
        
        // Insérer les connaissances si elles existent
        if ($request->filled('knowledges')) {
            foreach ($request->input('knowledges') as $knowledge) {
                OfferKnowledge::create([
                    'offer_id' => $lastOfferId,
                    'knowledge' => $knowledge,
                ]);
            }
        }
        
        // Insérer les éléments "se valora" si ils existent
        if ($request->filled('se-valora')) {
            foreach ($request->input('se-valora') as $niceToHave) {
                OfferNiceToHave::create([
                    'offer_id' => $lastOfferId,
                    'nice_to_have' => $niceToHave,
                ]);
            }
        }
        
        // Redirection après l'insertion réussie
        return redirect('/company/offers/step-3');
    }


    public function dispStepThree()
    {
        if (url()->previous() !== url('/company/offers/step-2')) {
            return redirect('/company/myOffers');
        }
        
        return view('Company.Offers.add-offer.step-3');
    }
    


    public function postStepThree(Request $request)
    {
        // Validation des données
        $request->validate([
            'benefits_titles' => 'nullable|array',
            'benefits_titles.*' => 'required_with:benefits_descriptions.*|string|max:255',
            'benefits_descriptions' => 'nullable|array',
            'benefits_descriptions.*' => 'required_with:benefits_titles.*|string|max:1000',
        ]);

        // Récupérer le dernier ID de l'offre
        $lastOfferId = Offers::latest('id')->value('id');

        if (!$lastOfferId) {
            return redirect()->back()->withErrors(['error' => 'No se encuentra ninguna oferta.']);
        }

        // Vérification et insertion des avantages
        if ($request->filled('benefits_titles') && $request->filled('benefits_descriptions')) {
            $benefitsTitles = $request->input('benefits_titles');
            $benefitsDescriptions = $request->input('benefits_descriptions');

            foreach ($benefitsTitles as $index => $title) {
                OfferBenefit::create([
                    'offer_id' => $lastOfferId,
                    'title' => $title,
                    'benefit' => $benefitsDescriptions[$index] ?? '',
                ]);
            }
        }

        return redirect('/company/myOffers')->with('success', 'La oferta se ha creado con éxito.');
    }


    public function destroyOffer($id)
    {
        try {
            $offer = Offers::findOrFail($id);
            $offer->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Oferta eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la oferta'
            ], 500);
        }
    }


    public function viewOffer($id)
    {

        $offerId = $id;
        $offer = Offers::where('id', $offerId)
               ->where('id_company', Auth::user()->id)
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
        $relatedOfferIds = OfferCategory::whereIn('name', $categoryNames)->pluck('offer_id');

        // Récupérer les offres liées à ces offer_ids
        $relatedOffers = Offers::whereIn('id', $relatedOfferIds)->take(6)->get();
        
        return view('Company.Offers.view-offer', compact('offer', 'aboutOffer', 'applicationCount', 'responsibilities', 'knowledges', 'niceToHaves', 'benefits', 'categories', 'skills', 'languages', 'relatedOffers'));
    }



    public function editOffer($id)
    {

        $offerId = $id;
        $offer = Offers::where('id', $offerId)
               ->where('id_company', Auth::user()->id)
               ->firstOrFail();
        $aboutOffer = AboutOffer::where('offer_id', $offerId)->first();
        $responsibilities = OfferResponsibilities::where('offer_id', $offerId)->get();
        $knowledges = OfferKnowledge::where('offer_id', $offerId)->get();
        $niceToHaves = OfferNiceToHave::where('offer_id', $offerId)->get();
        $benefits = OfferBenefit::where('offer_id', $offerId)->get();
        $offer_categories = OfferCategory::where('offer_id', $offerId)->get();
        $skills = OfferSkill::where('offer_id', $offerId)->get();
        $languages = OfferLanguage::where('offer_id', $offerId)->get();
        $categories = Category::all();

        
        $categoryNames = $offer_categories->pluck('name');

        // Récupérer les offer_ids de toutes les lignes dans offer_categories où la catégorie correspond à l'une des catégories de l'offre actuelle
        $relatedOfferIds = OfferCategory::whereIn('name', $categoryNames)->pluck('offer_id');

        // Récupérer les offres liées à ces offer_ids
        $relatedOffers = Offers::whereIn('id', $relatedOfferIds)->take(6)->get();
        
        return view('Company.Offers.edit-offer.all-steps', compact('offer', 'aboutOffer', 'responsibilities', 'knowledges', 'niceToHaves', 'benefits', 'offer_categories', 'categories', 'skills', 'languages', 'relatedOffers'));
    }
    


    
    public function editTheOffer(Request $request)
    {
        $request->validate([
            'jobTitle' => 'required|string|max:255',
            'candidates' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'jobType' => 'required|string|in:Tiempo completo,Media jornada,Remoto,Hibrido,Jornada intensiva',
            's1-minSalary' => 'required|numeric|min:0',
            's1-maxSalary' => 'required|numeric|min:0|gte:s1-minSalary',
            'job_category' => 'required|exists:categories,name',
            'skills' => 'required|array|min:1',
            'skills.*' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string|max:255', 
            'knowledges' => 'nullable|array', 
            'knowledges.*' => 'string|max:255',
            'se-valora' => 'nullable|array',
            'se-valora.*' => 'string|max:255',
            'benefits_titles' => 'nullable|array',
            'benefits_titles.*' => 'required_with:benefits_descriptions.*|string|max:255',
            'benefits_descriptions' => 'nullable|array',
            'benefits_descriptions.*' => 'required_with:benefits_titles.*|string|max:1000',
            'deadline' => 'required|date|after:today',
        ]);
        

        $offerId = $request->input('offer_id');
        if (!$offerId) {
            return back()->withErrors(['offer_id' => 'L\'identifiant de l\'offre est requis.']);
        }


        // Supprimer tous les skills liés à cette offre
        DB::table('offer_skills')->where('offer_id', $offerId)->delete();
        DB::table('about_offers')->where('offer_id', $offerId)->delete();
        DB::table('offer_responsibilities')->where('offer_id', $offerId)->delete();
        DB::table('offer_knowledge')->where('offer_id', $offerId)->delete();
        DB::table('offer_nice_to_haves')->where('offer_id', $offerId)->delete();
        DB::table('offer_benefits')->where('offer_id', $offerId)->delete();
        


        $offer = DB::table('offers')
            ->where('id', $offerId)
            ->update([
                'title' => $request->jobTitle,
                'nbr_candidat_max' => $request->candidates,
                'place' => $request->location,
                'work_type' => $request->jobType,
                'starting_salary' => $request->input('s1-minSalary'),
                'final_salary' => $request->input('s1-maxSalary'),
                'experience_years' => $request->input('s1-experience-years') ?? 0,
                'category' => $request->job_category,
                'postulation_deadline' => $request->deadline,
                'id_company' => Auth::user()->id,
                'updated_at' => now(),
            ]);
                
        
        
        foreach ($request->skills as $skill) {
            DB::table('offer_skills')->insert([
                'offer_id' => $offerId,
                'skill_name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    



        if ($request->filled('description')) {
            AboutOffer::create([
                'offer_id' => $offerId,
                'description' => $request->input('description'),
            ]);
        }
        
        // Insérer les responsabilités si elles existent
        if ($request->filled('responsibilities')) {
            foreach ($request->input('responsibilities') as $responsibility) {
                OfferResponsibilities::create([
                    'offer_id' => $offerId,
                    'responsibility' => $responsibility,
                ]);
            }
        }
        
        // Insérer les connaissances si elles existent
        if ($request->filled('knowledges')) {
            foreach ($request->input('knowledges') as $knowledge) {
                OfferKnowledge::create([
                    'offer_id' => $offerId,
                    'knowledge' => $knowledge,
                ]);
            }
        }
        
        // Insérer les éléments "se valora" si ils existent
        if ($request->filled('se-valora')) {
            foreach ($request->input('se-valora') as $niceToHave) {
                OfferNiceToHave::create([
                    'offer_id' => $offerId,
                    'nice_to_have' => $niceToHave,
                ]);
            }
        }
        


        // Vérification et insertion des avantages
        if ($request->filled('benefits_titles') && $request->filled('benefits_descriptions')) {
            $benefitsTitles = $request->input('benefits_titles');
            $benefitsDescriptions = $request->input('benefits_descriptions');

            foreach ($benefitsTitles as $index => $title) {
                OfferBenefit::create([
                    'offer_id' => $offerId,
                    'title' => $title,
                    'benefit' => $benefitsDescriptions[$index] ?? '',
                ]);
            }
        }


        OfferStatus::updateOrCreate(
            ['id_offer' => $offerId],
            [
                'status' => "Revision",
                'updated_at' => now(),
            ]
        );
        
        return redirect('/company/offers/view-offer/' . $offerId);
    }
    
        


    // public function viewApplications($id)
    // {  
    //     $perPage = request('perPage', 10);
    //     $offer = Offers::findOrFail($id);
        
    //     dd($offer);
    //     $offersForMobile = Offers::where('id_company', Auth::user()->id)->orderBy('id', 'desc')->get();
               
        
    //     return view('Company.Offers.offer_application', compact('offer'));
    // }
    
    




    
    public function viewApplications($id)
    {  

        $offer = Offers::findOrFail($id);

        $perPage = request('perPage', 10);
        $applicationsCount = Application::where('id_offer', $id)->count();
        
        $applications = Application::where('id_offer', $id)->orderBy('id', 'desc')->paginate($perPage);
        $applicationsForMobile = Application::where('id_offer', $id)->orderBy('id', 'desc')->get();

        
        return view('Company.Offers.offer_application', compact('offer', 'applicationsCount', 'applications', 'applicationsForMobile'));
    }
    

    public function viewCandidature($id)
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
        


        if ($application->status == "Seleccionado") {
            $candidat->first_name = "*********" ;
            $candidat->last_name = "*********" ;
            $candidat->poste = "*********";
            $candidat->email = "*******************";
            $candidat->tel = "****************";
            $candidat->date_of_birth = "*********";
            $candidat->adresse = "*********";
            $candidat->gender = "*********";
            // $candidat->rating = "*********";
            $candidat->personal_picture_path = "*********";

            $application->motivation_letter = "*********************************************"; 
            $application->cv_name = "*********"; 
            
            // if(isset($about)){
            //     $about->description = "************************************";
            // }

            if(isset($linkedinLink)){
                $linkedinLink->link = "*********";
            }
            if(isset($xLink)){
                $xLink->link = "*********";
            }
            if(isset($websiteLink)){
                $websiteLink->link = "*********";
            }
            
            // $languagesString = "*********";

            foreach($experiences as $experience) {
                $experience->company_name = "*********";
                // $experience->post = "*********";
                $experience->location = "*********";
                // $experience->begin_date = "*********";
                // $experience->end_date = "*********";
                // $experience->work_type = "*********";
                // $experience->description = "*********";
            }

            // foreach($educations as $education) {
            //     $education->university_name = "*********";
            //     $education->subject = "*********";
            //     $education->begin_date = "*********";
            //     $education->end_date = "*********";
            //     $education->description = "*********";
            //     $education->education_logo_path = "*********";
            // }

            
            // foreach($skills as $skill) {
            //     $skill->description = "*********";
            // }
        }



        
        return view('Company.show-candidat', compact('candidat', 'application','about', 'linkedinLink', 'xLink', 'websiteLink', 'languagesString', 'experiences', 'educations', 'skills', 'languages'));
    }
    
    public function confermApp(Request $request){
        $request->validate([
            'id_app' => 'required'
        ]);

        $app = Application::findOrFail($request->id_app);
        $app->status = "En proceso";
        $app->save();

        return redirect()->back();
    }

    
    public function refusApp(Request $request){
        $request->validate([
            'id_app' => 'required'
        ]);

        $app = Application::findOrFail($request->id_app);
        $app->status = "Descartado";
        $app->save();

        return redirect()->back();
    }
}
