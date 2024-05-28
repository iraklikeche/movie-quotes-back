<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
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
        $this->quote = $quote->load(['comments', 'likes']);
        // $this->quote = $quote->load('user');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'comment_id' => $this->comment->id,
            'user' => $this->user,
            'quote' => $this->quote,
            'user_id' => $this->user->id,
            'username' => $this->user->username,
            'message' => 'Commented to your movie quote',
            'commented' => true,
            'time' => now()->toDateTimeString(),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'comment_id' => $this->comment->id,
            'user' => $this->user,
            'user_id' => $this->user->id,
            'quote' => $this->quote,
            'username' => $this->user->username,
            'commented' => true,
            'time' => now()->toDateTimeString(),
        ]);
    }
}
