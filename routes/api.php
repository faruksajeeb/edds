<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SmsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ThirdPartyApiAuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\HelpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('throttle:5,1')->group(function () {
    Route::prefix('v1')->name('api/v1/')->group(function () {
        Route::prefix('auth')->name('api/v1/auth/')->group(function () {
            Route::post('ThirdPartyApiUserLogin', [ThirdPartyApiAuthController::class, 'userLogin'])->name('ThirdPartyApiUserLogin');
        });
        Route::post('UserRegistration', [AuthController::class, 'userRegister'])->name('UserRegistration');
        Route::post('UserLogin', [AuthController::class, 'userLogin'])->name('UserLogin');
        Route::post('UserVerify', [AuthController::class, 'userVerify'])->name('UserVerify');

        Route::get('sms-response', [SmsController::class, 'newSmsResponse'])->name('sms-response');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', [AuthController::class, 'user'])->name('user');
            Route::delete('UserLogout', [AuthController::class, 'userLogout'])->name('UserLogout');
            Route::apiResource('Helps', HelpController::class);
        });
    });
});
