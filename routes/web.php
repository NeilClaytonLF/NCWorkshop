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
        Route::get('/jobs', 'index')->name('jobs');
        Route::get('/jobs/{job}', 'show');
        Route::post('/jobs', 'store');
        Route::delete('/jobs/{job}','delete');
    });
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::get('/users/{user}', 'show');
        Route::post('/users', 'store');
        Route::delete('/users/{user}', 'delete');
    });
});

require __DIR__.'/auth.php';
