<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticController;


Route::get('welcome', [StaticController::class, 'home'])
    ->name('welcome');

Route::get('/', [StaticController::class, 'home'])
    ->name('static.home');

Route::get('about', [StaticController::class, 'about'])
    ->name('about');

Route::get('contact', [StaticController::class, 'contact'])
    ->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
