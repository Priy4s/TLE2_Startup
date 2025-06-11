<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;


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

require __DIR__.'/auth.php';
