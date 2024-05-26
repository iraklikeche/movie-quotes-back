<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();

        return response()->json($notifications);
    }

}
