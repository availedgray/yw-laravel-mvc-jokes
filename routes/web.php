<?php

use App\Http\Controllers\JokeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticController;

// Static Routes
Route::get('/', [StaticController::class, 'home'])->name('home');
Route::get('/welcome', [StaticController::class, 'home'])->name('welcome');
Route::get('/about', [StaticController::class, 'about'])->name('about');
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');

// Joke Routes
Route::get('jokes/search', [JokeController::class, 'search'])->name('jokes.search');
Route::resource('/jokes', JokeController::class)->except(['index', 'show'])->middleware('auth');
Route::get('/jokes', [JokeController::class, 'index'])->name('jokes.index');
Route::get('/jokes/{joke}', [JokeController::class, 'show'])->name('jokes.show');

// User Routes
Route::group(['middleware' => ['auth', 'role:Staff|Admin|Super-Admin' ]], function () {
    Route::resource('users', UserController::class)->only([
        'index', 'show', 'create', 'store', 'edit', 'update', 'destroy'
    ]);
});

// Administration Dashboard
Route::get('/dashboard', [StaticController::class, 'admin'])
    ->middleware(['auth', 'verified', 'role:Staff|Admin|Super-Admin'])
    ->name('dashboard');

// Guest Dashboard
Route::get('/guest-dashboard', [StaticController::class, 'guestDashboard'])
    ->name('guest.dashboard');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'verified', 'role:Staff|Admin|Super-Admin']
], function () {

    Route::get('/permissions', [RolesAndPermissionsController::class, 'index'])
        ->name('admin.permissions');

    Route::post('/assign_role', [RolesAndPermissionsController::class, 'store'])
        ->name('admin.assign-role');

    Route::delete('/revoke_role', [RolesAndPermissionsController::class, 'destroy'])
        ->name('admin.revoke-role');

    Route::resource('/users', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
