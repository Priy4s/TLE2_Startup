<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

use App\Http\Controllers\MicrosoftController;

use League\OAuth2\Client\Provider\GenericProvider;
use App\Services\MicrosoftGraphService;




Route::get('/microsoft/login', [MicrosoftController::class, 'redirectToProvider'])->name('microsoft.login');
Route::get('/microsoft/callback', [MicrosoftController::class, 'handleProviderCallback'])->name('microsoft.callback');
Route::get('/dashboard', [MicrosoftController::class, 'showDocuments'])->name('microsoft.dashboard');
Route::get('/microsoft/dashboard', [MicrosoftController::class, 'showDashboard'])->name('microsoft.dashboard');
Route::get('/microsoft/emails', [MicrosoftController::class, 'showEmails'])->name('microsoft.emails')->middleware('auth');

Route::get('/debug-token', function () {
    return session('ms_token') ?: 'Geen token gevonden';
});

// Standaard Laravel routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/lootbox', function () {
    return view('lootbox');
});

//Route::resource('workspaces', WorkspaceController::class)->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('workspaces', WorkspaceController::class);
});

// Google connection routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('google.callback');
Route::post('/google/disconnect', [GoogleController::class, 'disconnectGoogle'])
    ->middleware('auth')
    ->name('google.disconnect');
Route::get('/google/check', [GoogleController::class, 'checkConnection'])
    ->middleware('auth')
    ->name('google.check');


//Documents route
Route::get('/documents', function () {return view('alldocuments.documents-overview');})->name('documents.overview');
Route::get('/documents', [GoogleController::class, 'showDriveFiles'])->name('documents.overview');


require __DIR__.'/auth.php';
