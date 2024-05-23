<?php

namespace App\Listeners;

use App\Notifications\QuoteLikedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

        $event->quote->user->notify(new QuoteLikedNotification($event->quote));

    }
}
