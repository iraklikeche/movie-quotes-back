<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        Log::info('Fetching notifications for user:', ['user_id' => $user->id]);

        $notifications = $user->notifications;
        Log::info('Notifications fetched:', ['notifications' => $notifications]);

        return response()->json($notifications);
    }

}
