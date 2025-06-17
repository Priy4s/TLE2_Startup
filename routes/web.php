<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\LootboxController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::post('/lootbox/open', [LootboxController::class, 'open'])->name('lootbox.open');
});

require __DIR__.'/auth.php';
