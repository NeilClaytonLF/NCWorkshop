<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{JobController, UserController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return to_route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(JobController::class)->group(function () {
        Route::get('/jobs', 'index')->name('jobs.index');
        Route::get('/jobs/create', 'create')->name('jobs.create');
        Route::get('/jobs/{job}', 'show')->name('jobs.show');
        Route::post('/jobs', 'store')->name('jobs.store');
        Route::get('/jobs/{job}/edit', 'edit')->name('jobs.edit');
        Route::put('/jobs/{job}', 'update')->name('jobs.update');
        Route::delete('/jobs/{job}','destroy')->name('jobs.destroy');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/create', 'create')->name('users.create');
        Route::get('/users/{user}', 'show')->name('users.show');
        Route::post('/users', 'store')->name('users.store');
        Route::get('/users/{user}/edit', 'edit')->name('users.edit');
        Route::put('/users/{user}', 'update')->name('users.update');
        Route::delete('/users/{user}', 'destroy')->name('users.destroy');
        Route::get('/userlist', 'userlist');
    });
});

require __DIR__.'/auth.php';
