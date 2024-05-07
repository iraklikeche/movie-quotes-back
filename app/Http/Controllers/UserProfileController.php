<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function update(UpdateUserProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->only('new_username', 'new_password', 'new_password_confirmation', 'profile_image');
        if (isset($data['new_username'])) {
            $user->username = $data['new_username'];
        }

        if (isset($data['new_password'])) {
            $user->password = bcrypt($data['new_password']);
        }

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully!']);
    }
}
