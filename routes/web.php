<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lootbox', function () {
    return view('lootbox');
});

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

require __DIR__.'/auth.php';
