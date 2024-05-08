<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'new_username' => 'sometimes|required|string|min:3|max:255',
            'new_password' => 'sometimes|required|min:8|confirmed',
            'profile_image' => 'sometimes|file|image|max:2048',
        ];
    }
}
