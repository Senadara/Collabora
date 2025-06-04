<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AccountController,
    EventController,
    EventRegistController,
    PageController,
    SponsorshipController,
    SessionController,
    RatingController,
    RewardController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Web routes untuk aplikasi ini
|-------------------------------------------------------------------------- 
*/

// Landing & Dashboard
Route::get('/', fn () => view('welcome'));
Route::get('/dashboard', function () {
    $accounts = App\Models\Account::all();
    $events = App\Models\Event::all();
    return view('page.dashboard', ['events' => $events]);
});

// -------------------- AUTH --------------------
Route::post('/masuk', [SessionController::class, 'masuk']); // login
Route::post('/register', [AccountController::class, 'store']); // register
Route::get('/logout', [SessionController::class, 'logout']);
Route::get('/forgot-password', fn () => view('page.forgot-pass'));

// -------------------- EVENT --------------------
Route::get('/event', [EventController::class, 'index']);
Route::get('/event/create', [EventController::class, 'create']);
Route::post('/event', [EventController::class, 'store']);
Route::get('/event/edit/{id}', [EventController::class, 'edit']);
Route::put('/event/update/{id}', [EventController::class, 'update']);
Route::get('/event/{id}', [EventController::class, 'destroy']);
Route::get('/event/show/{id}', [EventController::class, 'show']);
Route::get('/search', [EventController::class, 'search'])->name('event.search');

// Admin Event
Route::get('/admin/manage-event', [EventController::class, 'adminEvent'])->name('adEv');
Route::get('/admin/event/create', [EventController::class, 'create']); // mungkin redundant

// -------------------- EVENT REGISTRATION --------------------
Route::post('/event_regist/addeventregist/{event}', [EventRegistController::class, 'addeventregist'])->name('regist.event');
Route::get('/volunteer', [EventRegistController::class, 'index']);
Route::get('/volunteer/show/{event}', [EventRegistController::class, 'show'])->name('show.volunteer');
Route::get('/volunteer/showAccepted/{event}', [EventRegistController::class, 'showAccepted'])->name('show.accepted.volunteer');
Route::get('/volunteer/deny/{id}', [EventRegistController::class, 'deny'])->name('deny.volunteer');
Route::get('/volunteer/accept/{id}', [EventRegistController::class, 'accept'])->name('accept.volunteer');

// -------------------- SPONSORSHIP --------------------
Route::get('/sponsorship/{id}', [SponsorshipController::class, 'show']);
Route::post('/sponsorship/addsponsorship', [SponsorshipController::class, 'addsponsorship'])->name("addsponsorship");
Route::get('/sponsorship/deny/{id}', [SponsorshipController::class, 'deny'])->name('deny.sponsor');
Route::get('/sponsorship/accept/{id}', [SponsorshipController::class, 'accept'])->name('accept.sponsor');
Route::get('/partner', [SponsorshipController::class, 'partner']);

// -------------------- ACCOUNT --------------------
Route::resource('/account', AccountController::class);
Route::get('/admin/manage-account', [AccountController::class, 'manage'])->name('manage');
Route::post('/biodata/create', [AccountController::class, 'createBiodata']);
Route::put('/biodata/update/{account_id}', [AccountController::class, 'updateBiodata']);

//Route::get('/admin/manage-account/{account}', [AccountController::class, 'destroy'])->name('account.destroy');

// -------------------- REWARD --------------------
Route::get('/download-certificate', [RewardController::class, 'download'])->name('certificate.download');
Route::get('/reward/{id}', [RewardController::class, 'reward']);

// -------------------- RATING --------------------
Route::resource('/rating', RatingController::class);
Route::get('/rating/{id}/show', [RatingController::class, 'showByEvent']);
