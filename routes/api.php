<?php

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\CheckLoggedIn;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(SessionController::class)->group(function () {
    Route::middleware([CheckLoggedIn::class])->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    Route::post('/logout', 'logout')->middleware('auth:sanctum');


});


Route::prefix('/email')->controller(VerificationController::class)->group(function () {
    Route::get('/verify/{id}/{hash}', 'verify')
         ->name('verification.verify')
         ->middleware('signed');

    Route::post('/resend', 'resend')
         ->name('verification.resend');
});