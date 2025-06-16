<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';