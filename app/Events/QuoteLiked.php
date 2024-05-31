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
    public $user;
    public $likeCount;


    /**
     * Create a new event instance.
     */
    public function __construct(Quote $quote, $user, $likeCount)
    {
        $this->quote = $quote->load(['comments', 'likes']);
        $this->user = $user;
        $this->likeCount = $likeCount;

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
            'message' => 'Reacted to your quote',
            'reacted' => true,
            'read_at' => null,
            'likeCount' => $this->likeCount,
            'created_at' => now()->toISOString(),
            'time' => now()->diffForHumans(),
        ];
    }
}
