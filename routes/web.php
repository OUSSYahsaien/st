<?php

use App\Http\Controllers\Admin\AdminCandidatsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOffersController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\NotificationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatAuthController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\Admin\AdminCompaniesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\SectorsController;
use App\Http\Controllers\Company\Auth\CompanyAuthController;
use App\Http\Controllers\Company\Auth\CompanyController;
use App\Http\Controllers\CompanyOffersController;
use App\Http\Controllers\TeamMemberController;

Route::get('/', [AdminController::class, 'checkAuth']);

Route::get('/login', function () {
    return redirect()->route('candidat.login');
})->name('login');

Route::prefix('candidat')->name('candidat.')->group(function () {
    Route::middleware('guest:candidat')->group(function () {
        Route::get('login', [CandidatAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [CandidatAuthController::class, 'login']);
        Route::get('register', [CandidatAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [CandidatAuthController::class, 'register']);
        Route::get('offers', [CandidatController::class, 'showOffersForm'])->name('offers');        
        Route::get('search-offers-g', [OffersController::class, 'showSearchOffersForm'])->name('search.offers.guest');
        Route::get('show-offer-g', [OffersController::class, 'showOffer'])->name('search.offer.guest');
        Route::post('/filter-offers-g', [OffersController::class, 'filterOffers'])->name('filter.offers.g');
    });
    
    Route::middleware('auth:candidat')->group(function () {
        Route::get('show-offer/{id}', [OffersController::class, 'showOffer'])->name('show.offer');
        Route::get('search-offers', [OffersController::class, 'showSearchOffersForm'])->name('search.offers');
        Route::get('dashboard', [CandidatAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [CandidatAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [CandidatController::class, 'showProfileForm'])->name('profile');
        Route::get('test', [CandidatController::class, 'test'])->name('test');
        Route::get('offers', [CandidatController::class, 'showOffersForm'])->name('offers');
        Route::post('update-avatar', [CandidatController::class, 'updateAvatar'])->name('update.avatar');
        Route::post('update-social-links', [CandidatController::class, 'updateSocialLinks'])->name('update.social.links');
        Route::get('/edit/profile', [EditProfileController::class, 'showMyprofileForm'])->name('edit.profile');
        Route::post('add-skill', [CandidatController::class, 'addNewSkill'])->name('add.skill');
        Route::post('edit-skill', [CandidatController::class, 'editSkill'])->name('edit.skill');
        Route::delete('delete-skill', [CandidatController::class, 'deleteSkill'])->name('delete.skill');
        Route::post('/update-details', [CandidatController::class, 'updateDetails'])->name('update.details');
        Route::post('/edit-about', [CandidatController::class, 'editAbout'])->name('edit.about');
        Route::post('/add-experience', [CandidatController::class, 'addExperience'])->name('add.experience');
        Route::post('/add-education', [CandidatController::class, 'addEducation'])->name('add.education');
        Route::post('/upload-cv', [CandidatController::class, 'uploadCV'])->name('upload.cv');
        Route::post('/upload-profile-picture', [EditProfileController::class, 'uploadProfilePicture'])->name('upload.profile.picture');
        Route::post('/update-first-infos', [EditProfileController::class, 'updateFirstInfos'])->name('update.first.infos');
        Route::delete('delete_document', [EditProfileController::class, 'deleteDocument'])->name('delete.document');
        Route::post('/edit-experience', [CandidatController::class, 'editExperience'])->name('edit.experience');
        Route::post('/edit-email', [CandidatController::class, 'editCandidatEmail'])->name('edit.email');
        Route::post('/edit-password', [CandidatController::class, 'editCandidatPassword'])->name('edit.password');
        Route::post('/update-preferences', [CandidatController::class, 'updatePreferences'])->name('update.preferences');


        Route::post('/password-reset-link', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
        Route::get('/password-reset-form', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
        Route::post('/password-reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');


        
        
        Route::post('/filter-offers', [OffersController::class, 'filterOffers'])->name('filter.offers');
        
        Route::post('/offer-apply', [OffersController::class, 'applicationNormale'])->name('offer.normale.application');
        Route::post('/offer-custom-apply', [OffersController::class, 'applicationCustom'])->name('offer.custom.application');
        

        Route::get('/education/{id}/edit', [CandidatController::class, 'editEducation']);
        Route::put('/update/education', [CandidatController::class, 'updateEducation'])->name('update.education');
        Route::delete('/education/{id}', [CandidatController::class, 'deleteEducation']);
        Route::delete('/experience/{id}', [CandidatController::class, 'deleteExperience']);
        
        Route::delete('/application/{id}', [OffersController::class, 'deleteApplication'])->name('application.delete');
        Route::post('/disactive/compte', [CandidatController::class, 'disactiveCompte'])->name('disactive.compte');
        Route::post('/request-review', [CandidatController::class, 'requestReview'])->name('request.review');

        Route::post('/update-schedule', [CandidatAuthController::class, 'updateSchedule'])->name('schedule.update');



        Route::post('/notifications/{id}/read', [CandidatAuthController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', [CandidatAuthController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        
    });
});




Route::prefix('company')->name('company.')->group(function () {
    // Routes accessibles uniquement pour les invités (non authentifiés)
    Route::middleware('guest:company')->group(function () {
        Route::get('login', [CompanyAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [CompanyAuthController::class, 'login']);
        Route::get('register', [CompanyAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [CompanyAuthController::class, 'register']);
    });

    // Routes accessibles uniquement pour les utilisateurs authentifiés
    Route::middleware('auth:company')->group(function () {
        Route::get('dashboard', [CompanyAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [CompanyAuthController::class, 'logout'])->name('logout');
        Route::post('logout', [CompanyAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [CompanyController::class, 'showProfileForm'])->name('profile');
        
        // profile routes
        Route::post('edit-description', [CompanyController::class, 'editDescription'])->name('edit.description');
        Route::post('add-contact', [CompanyController::class, 'addContact'])->name('add.contact');
        Route::post('update-social-links', [CompanyController::class, 'updateSocialLinks'])->name('update.social.links');
        Route::get('edit-profile', [CompanyController::class, 'editProfile'])->name('edit.profile');
        
        Route::post('upload-personal-logo', [CompanyController::class, 'uploadPersonalLogo'])->name('upload.personal.logo');
        Route::post('/remove-city', [CompanyController::class, 'removeCity'])->name('user.removeCity');
        Route::post('/update-profile', [CompanyController::class, 'updateProfile'])->name('update.profile');
        Route::post('/edit-email', [CompanyController::class, 'editCompanyEmail'])->name('edit.email');
        Route::post('/edit-password', [CompanyController::class, 'editCompanyPassword'])->name('edit.password');
        Route::post('/update-preferences', [CompanyController::class, 'updatePreferences'])->name('update.preferences');
        
        Route::get('add-in-equipe', [CompanyController::class, 'addInEquipe'])->name('add.in.equipe');
        
        Route::post('/upload-profile-picture', [CompanyController::class, 'uploadProfilePicture'])->name('upload.profile.picture');
        
        
        
        Route::post('/password-reset-link', [CompanyController::class, 'sendResetLink'])->name('password.email');
        
        
        Route::post('/update-first-infos', [CompanyController::class, 'updateFirstInfos'])->name('update.first.infos');
        Route::post('/update-second-infos/{id}', [CompanyController::class, 'updateSecondInfos'])->name('update.second.infos');
        
        Route::get('view-team-member/{id}', [TeamMemberController::class, 'viewTeamMember'])->name('view.team.member');
        Route::get('edit-team-member/{id}', [CompanyController::class, 'editInEquipe'])->name('edit.in.equipe');
        
        Route::post('/edit-about', [TeamMemberController::class, 'editAboutTeamMember'])->name('edit.about.team.member');
        Route::post('update-social-links-tm', [TeamMemberController::class, 'updateTeamMemberSocialLinks'])->name('update.team.member.social.links');
        Route::post('/update-details', [TeamMemberController::class, 'updateDetails'])->name('update.team.members.details');
        Route::post('update-avatar', [TeamMemberController::class, 'updateTeamMemberAvatar'])->name('update.team.member.avatar');
        
        
        
        // offers routes
        Route::get('myOffers', [CompanyOffersController::class, 'myOffers'])->name('my.offers');
        // add offer
        Route::get('offers/step-1', [CompanyOffersController::class, 'dispStepOne'])->name('my.offers.steep.one');
        Route::get('offers/step-2', [CompanyOffersController::class, 'dispStepTwoo'])->name('my.offers.steep.twoo');
        Route::get('offers/step-3', [CompanyOffersController::class, 'dispStepThree'])->name('my.offers.steep.three');
        
        Route::post('step-1', [CompanyOffersController::class, 'postStepone'])->name('post.job.step.one');
        Route::post('step-2', [CompanyOffersController::class, 'postStepTwoo'])->name('post.job.step.twoo');
        Route::post('step-3', [CompanyOffersController::class, 'postStepThree'])->name('post.job.step.three');
        
        // view offer
        Route::get('offers/view-offer/{id}', [CompanyOffersController::class, 'viewOffer'])->name('my.offers.view.offer');
        
        // delete offer
        Route::delete('/offers/{id}', [CompanyOffersController::class, 'destroyOffer'])->name('offers.destroy');
        
        // edit offer
        Route::get('offers/edit-offer/{id}', [CompanyOffersController::class, 'editOffer'])->name('my.offers.edit.offer');
        Route::post('offers/edit-offer/{id}', [CompanyOffersController::class, 'editTheOffer'])->name('edit.offer');
        
        // read offer applications 
        Route::get('offers/view-applications/{id}', [CompanyOffersController::class, 'viewApplications'])->name('my.offers.view.applications');

        
        // show candidat profile 
        Route::get('offers/view-candidat/{id}', [CompanyOffersController::class, 'viewCandidature'])->name('my.offers.view.candidat');

        
        Route::post('/disactive/compte', [CompanyController::class, 'disactiveCompte'])->name('disactive.compte');
        Route::post('update-member-avatar', [TeamMemberController::class, 'updateMemberAvatar'])->name('update.member.avatar');

        Route::post('/request-review', [CompanyController::class, 'requestReview'])->name('request.review');
        
        Route::post('/conferm-app', [CompanyOffersController::class, 'confermApp'])->name('conferm.app');
        Route::post('/refus-app', [CompanyOffersController::class, 'refusApp'])->name('refus.app');


        Route::post('/notifications/{id}/read', [CompanyAuthController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', [CompanyAuthController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        
        
    });
});







Route::prefix('administration')->name('administration.')->group(function () {
    Route::middleware('guest:administration')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminController::class, 'login']);
    });

    Route::middleware('auth:administration')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/update-events', [AdminController::class, 'updateEvents'])->name('update.events');

        Route::get('company', [AdminCompaniesController::class, 'allCompanies'])->name('companies');
        Route::get('offers', [AdminController::class, 'offers'])->name('offers');
        Route::get('candidats', [AdminController::class, 'allCandidats'])->name('candidats');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');



        // Routes for adding an offer
        Route::get('create-offer/step-1', [AdminOffersController::class, 'dispStepOne'])->name('create.offer.steep.one');
        Route::get('create-offer/step-2', [AdminOffersController::class, 'dispStepTwoo'])->name('create.offer.steep.twoo');
        Route::get('create-offer/step-3', [AdminOffersController::class, 'dispStepThree'])->name('create.offer.steep.three');

        Route::post('step-1', [AdminOffersController::class, 'postStepone'])->name('post.job.step.one');
        Route::post('step-2', [AdminOffersController::class, 'postStepTwoo'])->name('post.job.step.twoo');
        Route::post('step-3', [AdminOffersController::class, 'postStepThree'])->name('post.job.step.three'); 
        
        Route::get('offers/view-offer/{id}', [AdminOffersController::class, 'viewOffer'])->name('view.offer');
        
        
        
        Route::post('update-status', [AdminOffersController::class, 'updateOfferStatus'])->name('update.offer.status'); 

        Route::get('offers/edit-offerr/{id}', [AdminOffersController::class, 'editOffer'])->name('edit.offerr');
        Route::post('offers/edit-offer/{id}', [AdminOffersController::class, 'editTheOffer'])->name('edit.offer');

        Route::get('candidats/view-candidat/{id}', [AdminCandidatsController::class, 'viewCandidature'])->name('view.candidat');


        Route::get('candidats/open', [AdminController::class, 'openToOpportunitiesCandidats'])->name('candidats.open');
        Route::get('candidats/in-progres', [AdminController::class, 'inProgressCandidats'])->name('candidats.in.progres');

        
        Route::get('companies/new', [AdminCompaniesController::class, 'newCompanies'])->name('companies.new');
        Route::get('companies/in-progres', [AdminCompaniesController::class, 'inProgressCompanies'])->name('companies.in.progres');
        Route::get('companies/homo', [AdminCompaniesController::class, 'homoCompanies'])->name('companies.homo');

        // routes updates infos candidats
        Route::post('/candidat/update-details', [AdminCandidatsController::class, 'updateDetails'])->name('candidat.update.details');
        Route::post('/candidat/update-social-links', [AdminCandidatsController::class, 'updateSocialLinks'])->name('candidat.update.social.links');
        Route::post('/candidat/edit-about', [AdminCandidatsController::class, 'editAbout'])->name('candidat.edit.about');
        Route::post('/candidat/add-experience', [AdminCandidatsController::class, 'addExperience'])->name('candidat.add.experience');
        Route::post('/candidat/edit-experience', [AdminCandidatsController::class, 'editExperience'])->name('candidat.edit.experience');
        Route::post('/candidat/add-education', [AdminCandidatsController::class, 'addEducation'])->name('candidat.add.education');
        Route::get('/candidats/view-candidat/administration/education/{id}/edit', [AdminCandidatsController::class, 'editEducation']);
        Route::put('/candidats/update/education', [AdminCandidatsController::class, 'updateEducation'])->name('candidat.update.education');
        Route::delete('/candidat/education/{id}', [AdminCandidatsController::class, 'deleteEducation']);
        Route::post('/candidat/add-skill', [AdminCandidatsController::class, 'addNewSkill'])->name('candidat.add.skill');
        Route::post('/candidat/edit-skill', [AdminCandidatsController::class, 'editSkill'])->name('candidat.edit.skill');
        Route::delete('/candidat/delete-skill', [AdminCandidatsController::class, 'deleteSkill'])->name('candidat.delete.skill');
        Route::post('/candidat/update-avatar', [AdminCandidatsController::class, 'updateAvatar'])->name('candidat.update.avatar');
        Route::get('/candidats/edit/profile/{id}', [AdminCandidatsController::class, 'showMyprofileForm'])->name('candidat.edit.profile');
        Route::post('/candidats/upload-profile-picture', [AdminCandidatsController::class, 'uploadProfilePicture'])->name('candidat.upload.profile.picture');
        Route::post('/candidats/update-first-infos', [AdminCandidatsController::class, 'updateFirstInfos'])->name('candidat.update.first.infos');
        Route::post('/candidats/upload-cv', [AdminCandidatsController::class, 'uploadCV'])->name('candidat.upload.cv');
        Route::delete('/candidats/delete_document/{id}', [AdminCandidatsController::class, 'deleteDocument'])->name('candidat.delete.document');
        Route::post('/candidats/edit-email', [AdminCandidatsController::class, 'editCandidatEmail'])->name('candidat.edit.email');
        Route::post('/candidats/edit-password', [AdminCandidatsController::class, 'editCandidatPassword'])->name('candidat.edit.password');
        Route::post('/candidats/update-preferences', [AdminCandidatsController::class, 'updatePreferences'])->name('candidat.update.preferences');
        Route::post('/candidats/disactive/compte/{id}', [AdminCandidatsController::class, 'disactiveCompte'])->name('candidat.disactive.compte');
        Route::post('/candidats/active/compte/{id}', [AdminCandidatsController::class, 'activeCompte'])->name('candidat.active.compte');
        





        Route::get('/calendar', [EventController::class, 'index'])->name('calendar.index');
        Route::get('/events', [EventController::class, 'getEvents'])->name('events.get');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

        
        
        Route::get('/candidats/view-candidat-apps/{id}', [AdminCandidatsController::class, 'viewCandidatApps'])->name('candidats.apps');
        
        
        
        
        // admin comany manage 
        Route::get('/companies/profile/{id}', [AdminCompaniesController::class, 'profileCompany'])->name('companies.profile');
        Route::get('/companies/profile-edit/{id}', [AdminCompaniesController::class, 'editProfileCompany'])->name('companies.profile.edit');
        Route::get('/companies/publicated-offers/{id}', [AdminCompaniesController::class, 'offersCompany'])->name('companies.offersCompany');
        
        Route::post('companies/edit-email', [AdminCompaniesController::class, 'editCompanyEmail'])->name('company.edit.email');
        Route::post('/company/disactive/compte/{id}', [AdminCompaniesController::class, 'disactiveCompte'])->name('company.disactive.compte');
        Route::post('/company/active/compte/{id}', [AdminCompaniesController::class, 'activeCompte'])->name('company.active.compte');
        Route::post('/company/edit-password', [AdminCompaniesController::class, 'editCandidatPassword'])->name('company.edit.password');
        Route::get('companies/offer/view-applications/{id}', [AdminCompaniesController::class, 'viewApplications'])->name('companies.offers.view.applications');
        Route::get('companies/offer/view-applications-pipeline/{id}', [AdminCompaniesController::class, 'viewApplicationsPipeline'])->name('companies.offers.view.applications.pipeline');
        Route::get('companies/offer/view-application/{id}', [AdminCompaniesController::class, 'viewApplication'])->name('companies.offers.view.application');


        Route::post('companies/update-application-status/{id}', [AdminCompaniesController::class, 'updateApplicationStatus'])->name('companies.application.updateStatus');
        Route::post('/companies/offer/view-application/administration/candidat/update-rating', [AdminCompaniesController::class, 'updateCandidatRating'])->name('companies.update.candidats.rating');
        Route::post('/candidats/view-candidat/administration/candidat/update-rating', [AdminCompaniesController::class, 'updateCandidatRating'])->name('candidats.update.rating');

        Route::get('/companies/view-team-member/{id}', [AdminCompaniesController::class, 'viewTeamMember'])->name('company.view.team.member');



        Route::get('/languages', [LanguageController::class, 'index'])->name('languages');
        Route::post('/languages', [LanguageController::class, 'store'])->name('languages.store');
        Route::put('/languages/{language}', [LanguageController::class, 'update'])->name('languages.update');
        Route::delete('/languages/{language}', [LanguageController::class, 'destroy'])->name('languages.destroy');

        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
        Route::put('/categories/{language}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{language}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

        Route::get('/sectors', [SectorsController::class, 'index'])->name('sectors');
        Route::post('/sectors', [SectorsController::class, 'store'])->name('sectors.store');
        Route::put('/sectors/{sector}', [SectorsController::class, 'update'])->name('sectors.update');
        Route::delete('/sectors/{sector}', [SectorsController::class, 'destroy'])->name('sectors.destroy');


        Route::get('/revisions', [NotificationsController::class, 'getRevisionRequests']);
        Route::post('/notifications/{id}/read', [NotificationsController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', [NotificationsController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    });
});