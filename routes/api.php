<?php

use App\Http\Controllers\Api\V1\Search\SearchController;
use App\Http\Controllers\Api\V1\Filter\FilterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\APIFormaterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//ROUTE example: localhost/api/v1/...
Route::prefix('v1')->group(function () {
    Route::middleware('api')->prefix('auth')->group(function () {
        Route::post('login', [Auth\LoginController::class, 'login']);
        Route::post('register', [Auth\RegisterController::class, 'register']);
        Route::post('logout', [Auth\LogoutController::class, 'logout']);
        Route::post('refresh', [Auth\RefreshTokenController::class, 'refresh']);
        Route::post('me', [Auth\LoginController::class, 'me']);


    });

    Route::prefix('hotels')->group(function () {
//        dd("string");
//        Route::get('/', [SearchController::class, 'index']);
//        Route::get('/{searchQuery}', [SearchController::class, 'searchQuery']);
//        Route::get('{searchQuery}/filter={filterParams}', [FilterController::class, 'filter']);
        Route::get('filter={filterParams}/search', [FilterController::class, 'filter']);
//        Route::get('test', [FilterController::class, 'test']);

    });

    Route::prefix('formatter')->group(function () {
        Route::get('/', [APIFormaterController::class, 'index']);
    });

});

