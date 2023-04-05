<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowSingleArticleController;
use App\Http\Controllers\UserProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('',HomeController::class)->name('home');
Route::get('article/{slug}',ShowSingleArticleController::class)->name('single-article');
Route::get('user/{id}/profile',UserProfileController::class)->name('user-profile');
