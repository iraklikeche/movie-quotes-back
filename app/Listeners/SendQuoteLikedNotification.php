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
        if ($event->quote->user_id !== $event->user->id) {
            $event->quote->user->notify(new QuoteLikedNotification($event->quote, $event->user));
        }

    }
}
