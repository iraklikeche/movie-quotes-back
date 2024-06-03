<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CommentAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;
    public $user;
    public $quote;

    public function __construct(Comment $comment, $user, Quote $quote)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->quote = $quote;
        $this->quote = $quote->load('user');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user' => $this->user,
            'quote' => $this->quote,
            'username' => $this->user->username,
            'message' => [
                'en' => __('reactions.commented_to_your_movie_quote', [], 'en'),
                'ka' => __('reactions.commented_to_your_movie_quote', [], 'ka'),
            ],
            'commented' => true,
            'created_at' => Carbon::now(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'user' => $this->user,
            'quote' => $this->quote,
            'username' => $this->user->username,
            'message' => [
                'en' => __('reactions.commented_to_your_movie_quote', [], 'en'),
                'ka' => __('reactions.commented_to_your_movie_quote', [], 'ka'),
            ],
            'commented' => true,
            'created_at' => Carbon::now(),
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('App.Models.User.' . $this->quote->user_id);

    }
}
