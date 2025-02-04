<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutOffer;
use App\Models\Application;
use App\Models\Category;
use App\Models\Company;
use App\Models\OfferBenefit;
use App\Models\OfferCategory;
use App\Models\OfferKnowledge;
use App\Models\OfferLanguage;
use App\Models\OfferNiceToHave;
use App\Models\OfferResponsibilities;
use App\Models\Offers;
use App\Models\OfferSkill;
use App\Models\OfferStatus;
use App\Notifications\OfferStatusUpdated;
use Carbon\Carbon;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminOffersController extends Controller
{
    public function dispStepOne()
    {
        $categories = Category::all();

        return view('Admin.Offers.step-1', compact('categories'));
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
            'id_company' => 0,
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
    
        return redirect('/administration/create-offer/step-2');
    }

    
    public function dispStepTwoo()
    {
        if (url()->previous() !== url('/administration/create-offer/step-1')) {
            return redirect('/administration/offers');
        }


        return view('Admin.Offers.step-2');
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
        return redirect('/administration/create-offer/step-3');
    }


    public function dispStepThree()
    {
        if (url()->previous() !== url('/administration/create-offer/step-2')) {
            return redirect('/administration/offers');
        }
        
        return view('Admin.Offers.step-3');
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

        return redirect('/administration/offers')->with('success', 'La oferta se ha creado con éxito.');
    }




    
    public function viewOffer($id)
    {

        $offerId = $id;
        $offer = Offers::where('id', $offerId)
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

        $offerStatus = DB::table('offer_statuses')
        ->where('id_offer', $offerId)
        ->value('status');
        
        $categoryNames = $categories->pluck('name');

        $relatedOfferIds = OfferCategory::whereIn('name', $categoryNames)->pluck('offer_id');

        $relatedOffers = Offers::whereIn('id', $relatedOfferIds)->take(6)->get();
        
        return view('Admin.Offers.view.view-offer', compact('offer','offerStatus', 'aboutOffer', 'applicationCount', 'responsibilities', 'knowledges', 'niceToHaves', 'benefits', 'categories', 'skills', 'languages', 'relatedOffers'));
    }

    public function updateOfferStatus(Request $request){
        try {
            $offerStatus = OfferStatus::where('id_offer', $request->offer_id)->first();
            $offer = Offers::findOrFail($request->offer_id);
            
            if (!$offerStatus) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offer status not found'
                ], 404);
            }
    
            $offerStatus->status = $request->status;
            $offerStatus->save();

            if ($request->status == 'Publicada') {
                $offer->publication_date = Carbon::now();
            }

            $offer->save();


            $company = Company::findOrFail($offer->id_company);
            $company->notify(new OfferStatusUpdated($offer->id, $request->status));
            
            
    
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating status'
            ], 500);
        }
    }



    
    public function editOffer($id)
    {

        $offerId = $id;
        $offer = Offers::where('id', $offerId)
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
        
        return view('Admin.Offers.all-steps', compact('offer', 'aboutOffer', 'responsibilities', 'knowledges', 'niceToHaves', 'benefits', 'offer_categories', 'categories', 'skills', 'languages', 'relatedOffers'));
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
            'skills' => 'nullable|array|min:1',
            'skills.*' => 'nullable|string|max:255',
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
                
        
        if ($request->filled('skills')) {
            foreach ($request->skills as $skill) {
                DB::table('offer_skills')->insert([
                    'offer_id' => $offerId,
                    'skill_name' => $skill,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
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
        
        return redirect('/administration/offers/view-offer/' . $offerId);
    }
    
}

