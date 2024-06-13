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
    public $user;
    public $commentCount;

    /**
     * Create a new event instance.
     */
    public function __construct(Quote $quote, Comment $comment, $user, $commentCount)
    {
        $this->quote = $quote;
        $this->comment = $comment;
        $this->user = $user;
        $this->commentCount = $commentCount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('App.Models.User.' . $this->quote->user_id),
            new Channel('quote.' . $this->quote->id)
        ];

    }

    public function broadcastWith(): array
    {
        return [
            'quote' => $this->quote,
            'comment' => $this->comment,
            'user' => $this->user,
            'commentCount' => $this->commentCount,
            'message' => [
                'en' => __('reactions.commented_to_your_movie_quote', [], 'en'),
                'ka' => __('reactions.commented_to_your_movie_quote', [], 'ka'),
            ],
            'commented' => true,
            'read_at' => null,
            'created_at' => now()->toISOString(),
            ];
    }
}
