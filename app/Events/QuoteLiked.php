<?php

namespace App\Events;

use App\Models\Quote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteLiked implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $quote;
    public $message;
    public $user;
    public $time;
    public $read_at;
    public $likeCount;


    /**
     * Create a new event instance.
     */
    public function __construct(Quote $quote, $user, $likeCount)
    {
        $this->quote = $quote;
        $this->user = $user;
        $this->read_at = null;
        $this->likeCount = $likeCount;
        $this->time = now()->diffForHumans();
        $this->message = 'Your quote was liked by ' . $user->username;

    }

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
            'user' => $this->user,
            'message' => $this->message,
            'read_at' => $this->read_at,
            'likeCount' => $this->likeCount,
            'time' => now()->diffForHumans(),
        ];
    }
}
