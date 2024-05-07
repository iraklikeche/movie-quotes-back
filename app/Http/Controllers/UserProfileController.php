<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserProfileRequest;
use Illuminate\Http\Request;
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

    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_image')) {
            $filename = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $filename;
            $user->save();
        }

        return response()->json(['message' => 'Profile image updated successfully!', 'profile_image' => $user->profile_image]);
    }
    // public function updateProfileImage(Request $request)
    // {
    //     $request->validate([
    //         'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     $user = Auth::user();
    //     if ($request->hasFile('profile_image')) {
    //         $image = $request->file('profile_image');
    //         $filename = time() . '.' . $image->getClientOriginalExtension();
    //         $destinationPath = public_path('/images/profile');
    //         $image->move($destinationPath, $filename);
    //         $user->profile_image = '/images/profile/' . $filename;
    //         $user->save();

    //         return response()->json(['message' => 'Profile image updated successfully!', 'path' => $user->profile_image]);
    //     }

    //     return response()->json(['message' => 'Failed to update profile image'], 422);
    // }

}
