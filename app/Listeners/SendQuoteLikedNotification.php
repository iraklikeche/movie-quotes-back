<?php

namespace App\Listeners;

use App\Events\QuoteLiked;
use App\Notifications\QuoteLikedNotification;

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
        $event->quote->user->notify(new QuoteLikedNotification($event->quote, $event->user));
    }
}
