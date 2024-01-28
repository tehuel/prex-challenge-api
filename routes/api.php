<?php

use App\Http\Controllers\API\FavoriteController;
use App\Http\Controllers\API\GetController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiLogger;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([ApiLogger::class])->group(function () {
    Route::post('/login', LoginController::class);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/search', SearchController::class);
        Route::get('/favorite', FavoriteController::class);
        Route::get('/gif/{gif}', GetController::class);
    });
});
