<?php

namespace App\Listeners;

use App\Events\QuoteLiked;
use App\Notifications\QuoteLikedNotification;
use Illuminate\Support\Facades\Log;

class SendQuoteLikedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle(QuoteLiked $event)
    {
        // $event->quote->user->notify(new QuoteLikedNotification($event->quote, $event->user));
        Log::info('Handling QuoteLiked event', ['quote_id' => $event->quote->id, 'user_id' => $event->user->id]);

        // Check if the user is being notified
        if ($event->quote->user) {
            $event->quote->user->notify(new QuoteLikedNotification($event->quote, $event->user));
            Log::info('QuoteLikedNotification sent', ['quote_id' => $event->quote->id, 'user_id' => $event->user->id]);
        } else {
            Log::error('QuoteLikedNotification not sent - no user found', ['quote_id' => $event->quote->id]);
        }
    }
}
