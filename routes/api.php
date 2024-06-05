<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->as('api.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('categories/{category}/posts', PostController::class);
});

Route::prefix('auth')->as('api.')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login']);
    Route::post('signup', [\App\Http\Controllers\Api\Auth\AuthController::class,'signup']);
    Route::post('logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
});