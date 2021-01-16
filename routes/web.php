<?php

use App\Http\Controllers\GuidesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', UserController::class);
    Route::get('user/{user}/delete', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');

    Route::get('showAuthorsGuides/{user}', [GuidesController::class, 'showAuthorsGuides'])->name('guide.showAuthorsGuides');
    Route::get('guide/{guide}/delete', [GuidesController::class, 'destroy'])->name('guide.delete');
});

Route::resource('guide', App\Http\Controllers\GuidesController::class);

Route::resource('guide_step', App\Http\Controllers\GuideStepsController::class);
