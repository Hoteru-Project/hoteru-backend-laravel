<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth;

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

Route::middleware('api')->prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [Auth\LoginController::class, 'login'])->name("authentication.login");
        Route::post('register', [Auth\RegisterController::class, 'register'])->name("authentication.register");
        Route::post('logout', [Auth\LogoutController::class, 'logout'])->name("authentication.logout");
        Route::post('refresh', [Auth\RefreshTokenController::class, 'refresh'])->name("jwt.refresh");
        Route::post('me', [Auth\LoginController::class, 'me'])->name("authentication.me");
        Route::post("/forgot-password", [Auth\ResetPasswordController::class, "email"])->name("password.email");
        Route::post("/reset-password", [Auth\ResetPasswordController::class, "update"])->name("password.update");
        Route::post("/email/verification-notification", [Auth\VerifyEmailController::class, "verify"])->name("verification.verify");
        Route::post("/email/verify/{id}/{hash}", [Auth\VerifyEmailController::class, "send"])->name("verification.send");
    });
});

