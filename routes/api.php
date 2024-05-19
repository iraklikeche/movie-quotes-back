<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\QuoteController;
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

Route::get('/genres', [GenreController::class, 'index']);

Route::prefix('movies')->controller(MovieController::class)->group(function () {
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'destroy');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', [QuoteController::class, 'destroy'])->name('destroy');

});

Route::get('/movies/{movieId}/quotes', [QuoteController::class, 'quotesByMovie'])->name('quotesByMovie');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('quotes')->name('quotes.')->group(function () {
        Route::post('/', [QuoteController::class, 'store'])->name('store');
        Route::get('/', [QuoteController::class, 'index'])->name('index');
        Route::get('/{id}', [QuoteController::class, 'show'])->name('show');
        Route::put('/{id}', [QuoteController::class, 'update'])->name('update');
        Route::delete('/{id}', [QuoteController::class, 'destroy'])->name('destroy');

        Route::post('/{quoteId}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/{quoteId}/comments', [CommentController::class, 'index'])->name('comments.index');

        Route::post('/{quoteId}/likes', [LikeController::class, 'store'])->name('likes.store');
    });
});
