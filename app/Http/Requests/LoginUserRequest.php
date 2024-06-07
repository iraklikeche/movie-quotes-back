<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean'
        ];
    }
}
