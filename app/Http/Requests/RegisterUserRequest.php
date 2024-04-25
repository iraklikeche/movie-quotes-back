<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required|string|min:3|max:15|regex:/^[a-z0-9]*$/',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:15|confirmed|regex:/^[a-z0-9]*$/',
            'password_confirmation' => 'required|same:password',
        ];

    }
}
