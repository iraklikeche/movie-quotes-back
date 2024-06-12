<?php

namespace App\Events;

use App\Models\Quote;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuoteUnliked implements ShouldBroadcast
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
        $this->quote = $quote;
        $this->user = $user;
        $this->likeCount = $likeCount;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('quote.' . $this->quote->id);

    }

    public function broadcastWith(): array
    {
        return [
            'quote' => $this->quote,
            'user' => $this->user,
            'likeCount' => $this->likeCount,
        ];
    }
}
