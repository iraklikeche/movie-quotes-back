<?php

namespace App\Listeners;

use App\Events\QuoteCommented;
use App\Notifications\CommentAddedNotification;

class SendQuoteCommentNotification
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
    public function handle(QuoteCommented $event): void
    {
        $event->comment->quote->user->notify(new CommentAddedNotification($event->comment, $event->user));

    }
}
