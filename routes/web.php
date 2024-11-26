<?php

use App\Http\Controllers\JokeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticController;
use App\Models\Joke;

// Static Routes
Route::get('/', [StaticController::class, 'home'])->name('home');
Route::get('/welcome', [StaticController::class, 'home'])->name('welcome');
Route::get('/about', [StaticController::class, 'about'])->name('about');
Route::get('/contact', [StaticController::class, 'contact'])->name('contact');


// Trashed (Soft Deleted) jokes
Route::get('jokes/trash', [JokeController::class, 'trash'])
    ->name('jokes.trash')
    ->withTrashed();

// Individual joke restore/remove
Route::get('jokes/{joke}/trash/restore', [JokeController::class, 'restore'])
    ->name('jokes.trash-restore')
    ->withTrashed();
Route::delete('jokes/{joke}/trash/remove', [JokeController::class, 'remove'])
    ->name('jokes.trash-remove')
    ->withTrashed();
// all trashed jokes restore/remove
Route::post('jokes/trash/recover',[JokeController::class, 'recoverAll'])
    ->name('jokes.trash-recover')
    ->withTrashed();
Route::delete('jokes/trash/empty',[JokeController::class, 'empty'])
    ->name('jokes.trash-empty')
    ->withTrashed();
// Joke Routes
Route::get('jokes/search', [JokeController::class, 'search'])->name('jokes.search');
Route::resource('/jokes', JokeController::class)->except(['index', 'show'])->middleware('auth');
Route::get('/jokes', [JokeController::class, 'index'])->name('jokes.index');
Route::get('/jokes/{joke}', [JokeController::class, 'show'])->name('jokes.show');

// debugging routes
//Route::get('users/trash', function () {
//    return 'Trash route is accessible';
//});

// Trashed (Soft Deleted) users
Route::get('users/trash', [UserController::class, 'trash'])
    ->name('users.trash');
// Individual user restore/remove
Route::get('users/{user}/trash/restore', [UserController::class, 'restore'])
    ->name('users.trash-restore');
Route::delete('users/{user}/trash/remove', [UserController::class, 'remove'])
    ->name('users.trash-remove');
// all trashed users restore/remove
Route::post('users/trash/recover',[UserController::class, 'recoverAll'])
    ->name('users.trash-recover');
Route::delete('users/trash/empty',[UserController::class, 'empty'])
    ->name('users.trash-empty');
// User Routes
Route::group(['middleware' => ['auth', 'role:Staff|Admin|Super-Admin' ]], function () {
    Route::resource('users', UserController::class)->only([
        'index', 'show', 'create', 'store', 'edit', 'update', 'destroy',
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
