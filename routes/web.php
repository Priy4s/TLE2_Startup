<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\LootboxController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KikkermanController;
use App\Http\Controllers\CalendarController;

use App\Http\Controllers\MicrosoftController;

use League\OAuth2\Client\Provider\GenericProvider;
use App\Services\MicrosoftGraphService;




// in routes/web.php

// Microsoft routes
Route::get('/microsoft/login', [MicrosoftController::class, 'redirectToProvider'])->name('microsoft.login');
Route::get('/microsoft/callback', [MicrosoftController::class, 'handleProviderCallback'])->name('microsoft.callback');
Route::post('/microsoft/disconnect', [MicrosoftController::class, 'disconnect'])->name('microsoft.disconnect');
Route::get('/microsoft/check', [MicrosoftController::class, 'checkConnection'])->name('microsoft.check')->middleware('auth');

// Route om de Microsoft documenten te tonen (pas 'documents.microsoft' aan naar je wens)
Route::get('/documents/microsoft', [MicrosoftController::class, 'showDriveFiles'])->name('documents.microsoft');
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

Route::get('/kikkerman', [KikkermanController::class, 'index'])
    ->middleware('auth') // Zorg dat alleen ingelogde gebruikers erbij kunnen
    ->name('kikkerman.index');

//Route::resource('workspaces', WorkspaceController::class)->middleware('auth');
Route::resource('calendar', CalendarController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('workspaces', WorkspaceController::class);

    // Documents routes - main page & upload
    Route::get('/documents', [DocumentController::class, 'overview'])->name('documents.overview');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');

    // Google connection routes
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::post('/google/disconnect', [GoogleController::class, 'disconnectGoogle'])->name('google.disconnect');
    Route::get('/google/check', [GoogleController::class, 'checkConnection'])->name('google.check');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/lootbox/open', [LootboxController::class, 'open'])->name('lootbox.open');
});

Route::post('/workspaces/remove-document', [WorkspaceController::class, 'removeDocumentFromWorkspace'])->name('workspaces.removeDocument');

Route::post('/workspaces/add-document', [WorkspaceController::class, 'addDocumentToSelected'])->name('workspaces.addDocumentToSelected');
require __DIR__.'/auth.php';
