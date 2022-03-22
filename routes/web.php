<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoviesController;

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

Route::get('/', [MoviesController::class, 'index'])->name('index');

Route::get('/search', [MoviesController::class, 'search'])->name('search');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('movies', MoviesController::class)->only([
        'store'
    ]);

    Route::delete('movies', [MoviesController::class, 'destroy']);

    Route::get('/favoritas', [MoviesController::class, 'show'])->name("favoritas");

    Route::get('/dashboard', function () {
        return redirect('/favoritas');
    });
});