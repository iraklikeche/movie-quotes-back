<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteCommented implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public $quote;
    public $comment;
    public $message;
    public $read_at;
    public $user;
    public $time;
    public $commentCount;

    /**
     * Create a new event instance.
     */
    public function __construct(Quote $quote, Comment $comment, $user, $commentCount)
    {
        $this->quote = $quote;
        $this->comment = $comment;
        $this->user = $user;
        $this->read_at = null;
        $this->message = 'Your quote was commented by ' . $user->username;
        $this->commentCount = $commentCount;
        $this->time = now()->diffForHumans();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [
            new Channel('App.Models.User.' . $this->quote->user_id),
        new Channel('quote.' . $this->quote->id)
        ];

    }

    public function broadcastWith()
    {
        return [
            'quote' => $this->quote,
            'comment' => $this->comment,
            'user' => $this->user,
            'message' => $this->message,
            'read_at' => $this->read_at,
            'commentCount' => $this->commentCount,
            'time' => $this->time
        ];
    }
}
