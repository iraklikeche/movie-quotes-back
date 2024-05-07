<?php

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\CheckLoggedIn;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'authenticatedUser']);


Route::middleware('auth:sanctum')->controller(UserProfileController::class)->group(function () {
    Route::post('/user/update', 'update')->name('user.update');
});


Route::controller(SessionController::class)->group(function () {
    Route::middleware([CheckLoggedIn::class])->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login');
        Route::post('/forgot-password', 'forgotPassword');
        Route::post('/reset-password', 'resetPassword');
        Route::post('/reset-password/resend', 'resendResetLink');
        Route::post('/check-token-validity', 'checkTokenValid');
    });
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('logout');
});

Route::prefix('/email')->controller(VerificationController::class)->group(function () {
    Route::get('/verify/{id}/{hash}', 'verify')
         ->name('verification.verify')
         ->middleware('signed');
    Route::post('/resend', 'resend')
         ->name('verification.resend');
});


Route::get('/auth/redirect', function () {
    $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
    return $url;
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->stateless()->user();

    $authUser = User::updateOrCreate([
        'google_id' => $user->id
    ], [
        'email' => $user->email,
        'username' => $user->name,
        'email_verified_at' => now(),
    ]);

    Auth::login($authUser);

    return response()->json(['success' => 'YAY!']);

});
