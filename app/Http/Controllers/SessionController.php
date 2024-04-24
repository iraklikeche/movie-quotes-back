<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function register(RegisterUserRequest $request): JsonResponse
    {


        $user = User::create($request->validated());

        //  $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'User successfully registered.']);
    }
}
