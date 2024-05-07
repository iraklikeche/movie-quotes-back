<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SessionController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {

        $user = User::create($request->validated());

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'User successfully registered.']);
    }


    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->input('remember', false);

        if (Auth::attemptWhen($credentials, function (User $user) {
            return $user->hasVerifiedEmail();
        }, $remember)) {

            session()->regenerate();
            return response()->json(['message' => __('auth.login_success')]);
        }

        return response()->json(['message' => __('auth.login_fail')], 401);

    }

    public function logout(Request $request): JsonResponse
    {
        auth('web')->logout();
        session()->invalidate();

        session()->regenerateToken();
        return response()->json(['message' => 'You have been successfully logged out!']);
    }


    public function forgotPassword(Request $request): JsonResponse
    {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => __($status)]);
        }

        return response()->json(['email' => __($status)], 400);
    }


    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'You cannot reuse your old password.',
                'errors' => ['password' => ['You cannot reuse your old password.']]
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['status' => 'Password has been reset.']);
        } else {
            return response()->json([
                'message' => 'Token expired.',
                'errors' => ['password' => ['Token expired.']]
            ], 422);
        }
    }

    public function resendResetLink(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['status' => 'success', 'message' => __($status)]);
        }

        return response()->json(['status' => 'error', 'message' => __($status)], 400);
    }

    public function checkTokenValid(Request $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $tokenStatus = Password::tokenExists($user, $request->token);

        if (!$tokenStatus) {
            return response()->json([
                'message' => 'Token expired or invalid.',
                'status' => 'invalid'
            ], 422);
        }

        return response()->json(['status' => 'valid']);
    }




}
