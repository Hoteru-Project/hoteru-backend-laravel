<?php

use App\Http\Controllers\Api\V1\Search\SearchController;
use App\Http\Controllers\Api\V1\Filter\FilterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\APIFormaterController;
use App\Http\Controllers\Api\V1\UserController;

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
Route::middleware('api')->prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [Auth\LoginController::class, 'login'])->name("authentication.login");
        Route::post('register', [Auth\RegisterController::class, 'register'])->name("authentication.register");
        Route::post('logout', [Auth\LogoutController::class, 'logout'])->name("authentication.logout");
        Route::post('refresh', [Auth\RefreshTokenController::class, 'refresh'])->name("jwt.refresh");
        Route::get('me', [Auth\LoginController::class, 'me'])->name("authentication.me");
        Route::post("/forgot-password", [Auth\ResetPasswordController::class, "email"])->name("password.email");
        Route::post("/reset-password", [Auth\ResetPasswordController::class, "update"])->name("password.update");
        Route::post("/email/verification-notification", [Auth\VerifyEmailController::class, "send"])->name("verification.send");
        Route::get("/email/verify/{id}/{hash}", [Auth\VerifyEmailController::class, "verify"])->name("verification.verify");
    });

    Route::prefix("users")->middleware("auth:api")->group(function () {
        Route::patch("user", [UserController::class, "update"])->name("user.update");
    });

    Route::prefix('hotels')->group(function () {
        Route::get('/{searchQuery}', [SearchController::class, 'index']);
    });

    Route::prefix('hotel')->group(function () {
        Route::get('', [SearchController::class, 'getHotelByName']);
    });

    Route::prefix('formatter')->group(function () {
        Route::get('/', [APIFormaterController::class, 'index']);
    });

});

