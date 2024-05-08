<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->only('new_username', 'new_password', 'new_password_confirmation');
        if (isset($data['new_username'])) {
            $user->username = $data['new_username'];
        }

        if (isset($data['new_password'])) {
            $user->password = bcrypt($data['new_password']);
        }

        if ($request->hasFile('profile_image')) {
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_images');
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully!',
        ]);

    }
}
