<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\LootboxController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\KikkermanController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\MicrosoftController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\LinkController; // <-- NEW

// Microsoft routes
Route::get('/microsoft/login', [MicrosoftController::class, 'redirectToProvider'])->name('microsoft.login');
Route::get('/microsoft/callback', [MicrosoftController::class, 'handleProviderCallback'])->name('microsoft.callback');
Route::post('/microsoft/disconnect', [MicrosoftController::class, 'disconnect'])->name('microsoft.disconnect');
Route::get('/microsoft/check', [MicrosoftController::class, 'checkConnection'])->name('microsoft.check')->middleware('auth');

Route::get('/documents/microsoft', [MicrosoftController::class, 'showDriveFiles'])->name('documents.microsoft');

Route::get('/debug-token', function () {
    return session('ms_token') ?: 'Geen token gevonden';
});

// Public routes
Route::get('/', [WorkspaceController::class, 'index'])->middleware('auth');

Route::get('/lootbox', function () {
    return view('lootbox');
})->name('lootbox.index')->middleware('auth');

Route::get('/kikkerman', [KikkermanController::class, 'index'])
    ->middleware('auth')
    ->name('kikkerman.index');

Route::resource('calendar', CalendarController::class)->middleware('auth');

// Authenticated & Verified User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Workspaces CRUD
    Route::resource('workspaces', WorkspaceController::class)->middleware('auth');

    // Notes - Add/Delete Notes for Workspaces
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store')->middleware('auth');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy')->middleware('auth');

    // Links - Add/Delete Links for Workspaces
    Route::post('/links', [LinkController::class, 'store'])->name('links.store')->middleware('auth');
    Route::delete('/links/{link}', [LinkController::class, 'destroy'])->name('links.destroy')->middleware('auth');

    // Document management

    Route::get('/documents', [DocumentController::class, 'overview'])->name('documents.overview')->middleware('auth');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload')->middleware('auth');

// NIEUWE ROUTE: Om lokale bestanden veilig te serveren.
    Route::get('/documents/local/{file}', [DocumentController::class, 'serveLocalFile'])->name('documents.serve.local')->middleware('auth');

    // Google auth
    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
    Route::post('/google/disconnect', [GoogleController::class, 'disconnectGoogle'])->name('google.disconnect');
    Route::get('/google/check', [GoogleController::class, 'checkConnection'])->name('google.check');
});

// Lootbox (auth-only route)
Route::middleware(['auth'])->group(function () {
    Route::post('/lootbox/open', [LootboxController::class, 'open'])->name('lootbox.open')->middleware('auth');
});

Route::post('/workspaces/remove-document', [WorkspaceController::class, 'removeDocumentFromWorkspace'])->name('workspaces.removeDocument')->middleware('auth');

Route::post('/workspaces/add-document', [WorkspaceController::class, 'addDocumentToSelected'])->name('workspaces.addDocumentToSelected')->middleware('auth');


require __DIR__.'/auth.php';
