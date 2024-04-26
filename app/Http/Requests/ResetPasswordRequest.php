<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            function ($attribute, $value, $fail) {
                $user = User::where('email', $this->email)->first();
                if ($user && Hash::check($value, $user->password)) {
                    $fail('The :attribute must be different from your current password.');
                }
            }
        ];
    }
}
