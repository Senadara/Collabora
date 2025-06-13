<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\{
    Admin\CreatorController,
    AccountController,
    EventController,
    EventRegistController,
    ForgotPasswordController,
    PageController,
    SponsorshipController,
    SessionController,
    RatingController,
    ResetPasswordController,
    RewardController
};

use App\Models\Event;

Route::get('/copy-assets', function () {
    $sourcePath = '/home/senadara/repositories/Collabora/public';
    $targetPath = '/home/senadara/public_html/collabora.senadara.my.id';
    $foldersToCopy = ['img', 'css'];
    foreach ($foldersToCopy as $folder) {
        $source = $sourcePath . '/' . $folder;
        $target = $targetPath . '/' . $folder;
        
        // Hapus isi folder target jika ada
        if (File::exists($target)) {
            File::deleteDirectory($target);
        }
        
        // Copy folder dari source ke target
        File::copyDirectory($source, $target);
    }
    return "Folder img dan css berhasil di-copy ke $targetPath";
});

// -------------------- GUEST --------------------
Route::middleware('guest')->group(function () {
    // Landing & Dashboard
    Route::get('/', function () {
        $latestEvents = \App\Models\Event::orderBy('created_at', 'desc')->take(3)->get();
        return view('welcome', ['latestEvents' => $latestEvents]);
    });

    Route::get('/login-page', [SessionController::class, 'index'])->name('login');
    Route::post('/login', [SessionController::class, 'login']);
    Route::get('/register', [SessionController::class, 'create']);
    Route::post('/register', [SessionController::class, 'register']);

    // Forgot password
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});


// -------------------- ADMIN & EVENT CREATOR & USER --------------------
Route::middleware(['auth', 'role:user|event_creator|admin'])->group(function () {
    Route::get('/dashboard', function () {
        $events = App\Models\Event::all();
        return view('page.dashboard', ['events' => $events]);
    });
    Route::get('/logout', [SessionController::class, 'logout']);
    //Event-Creator
    Route::get('/event/show/{id}', [EventController::class, 'show']);
    Route::get('/search', [EventController::class, 'search'])->name('event.search');
    Route::post('/biodata/create', [AccountController::class, 'createBiodata']);
    Route::put('/biodata/update/{account_id}', [AccountController::class, 'updateBiodata']);
    Route::get('/download-certificate', [RewardController::class, 'download'])->name('certificate.download');
    Route::get('/reward/{id}', [RewardController::class, 'reward']);
    Route::resource('/rating', RatingController::class);
    Route::get('/rating/{id}/show', [RatingController::class, 'showByEvent']);
    Route::get('/daftar-creator', [CreatorController::class, 'form'])->name('creator.form');
    Route::post('/daftar-creator', [CreatorController::class, 'register'])->name('creator.register');
});


// -------------------- ADMIN & EVENT CREATOR --------------------
Route::middleware(['auth', 'role:admin|event_creator'])->group(function () {
    Route::get('/event', [EventController::class, 'index']);
    Route::get('/event/create', [EventController::class, 'create']);
    Route::post('/event', [EventController::class, 'store']);
    Route::get('/event/edit/{id}', [EventController::class, 'edit']);
    Route::put('/event/update/{id}', [EventController::class, 'update']);
    Route::get('/event/{id}', [EventController::class, 'destroy']);
    Route::post('/event_regist/addeventregist/{event}', [EventRegistController::class, 'addeventregist'])->name('regist.event');
    Route::get('/volunteer', [EventRegistController::class, 'index']);
    Route::get('/volunteer/show/{event}', [EventRegistController::class, 'show'])->name('show.volunteer');
    Route::get('/volunteer/showAccepted/{event}', [EventRegistController::class, 'showAccepted'])->name('show.accepted.volunteer');
    Route::get('/volunteer/deny/{id}', [EventRegistController::class, 'deny'])->name('deny.volunteer');
    Route::get('/volunteer/accept/{id}', [EventRegistController::class, 'accept'])->name('accept.volunteer');
    Route::get('/sponsorship/{id}', [SponsorshipController::class, 'show']);
    Route::post('/sponsorship/addsponsorship', [SponsorshipController::class, 'addsponsorship'])->name("addsponsorship");
    Route::get('/sponsorship/deny/{id}', [SponsorshipController::class, 'deny'])->name('deny.sponsor');
    Route::get('/sponsorship/accept/{id}', [SponsorshipController::class, 'accept'])->name('accept.sponsor');
    Route::get('/partner', [SponsorshipController::class, 'partner']);
});

// -------------------- ADMIN & EVENT CREATOR --------------------
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin Event
    Route::get('/admin/manage-event', [EventController::class, 'adminEvent'])->name('adEv');
    Route::get('/admin/event/create', [EventController::class, 'create']);
    Route::get('/creator-requests', [CreatorController::class, 'index'])->name('creator.requests');
    Route::post('/creator-approve/{id}', [CreatorController::class, 'approve'])->name('creator.approve');
    Route::post('/creator-reject/{id}', [CreatorController::class, 'reject'])->name('creator.reject');

});

// -------------------- EVENT REGISTRATION --------------------


// -------------------- SPONSORSHIP --------------------


// -------------------- ACCOUNT --------------------
Route::resource('/account', AccountController::class);
Route::get('/admin/manage-account', [AccountController::class, 'manage'])->name('manage');


//Route::get('/admin/manage-account/{account}', [AccountController::class, 'destroy'])->name('account.destroy');

// -------------------- REWARDING -------------------- //edit eventregistcontroller atau tambah controller baru
Route::get('/rewarding', [EventController::class, 'rewarding'])->name('rewarding');
Route::post('/rewarding', [EventController::class, 'store']);
Route::get('/rewarding/show/{id}', [EventController::class, 'show']);
Route::get('/search', [EventController::class, 'search'])->name('event.search');

// -------------------- REWARD --------------------


// -------------------- RATING --------------------
