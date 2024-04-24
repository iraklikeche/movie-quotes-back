<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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


            // it causes error I don't know why yet.
            // $request->session()->regenerate();

            return response()->json([
                'message' => 'User successfully logged in.',
            ]);
        }

        return response()->json([
            'message' => 'The provided credentials are incorrect or the email has not been verified.'
        ], 401);

    }

    public function logout(Request $request): JsonResponse
    {
        auth('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'You have been successfully logged out!']);
    }

}
