<?php

use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout']);

//reset password
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
//get category
Route::get('/categories', [ArticlesController::class, 'getCategory']);
//rate limiter is added in routes directly 60 request per minute
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    //articles
    Route::apiResource('articles', ArticlesController::class)->only(['index', 'show']);
    // User Preferences
    Route::post('/preferences', [UserPreferenceController::class, 'setPreferences']);
    Route::get('/preferences/{user_id}', [UserPreferenceController::class, 'getPreferences']);
    Route::get('/user-personalized-feed/{user_id}', [ArticlesController::class, 'personalizedFeed']);

});


