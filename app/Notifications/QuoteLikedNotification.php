<?php

namespace App\Notifications;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuoteLikedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $quote;
    public $user;



    /**
     * Create a new notification instance.
     */
    public function __construct(Quote $quote, $user)
    {
        $this->quote = $quote;
        $this->user = $user;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [ 'database', 'broadcast',];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'user' => $this->user,
            'user_id' => $this->user->id,
            'username' => $this->user->username,
            'image' => $this->user->profile_image_url,
            'message' => 'Your quote was liked!',
            'time' => now()->toDateTimeString(),
        ];
    }


    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([
            'quote_id' => $this->quote->id,
            'user' => $this->user,
            'user_id' => $this->user->id,
            'username' => $this->user->username,
            'image' => $this->user->profile_image_url,
            'message' => 'Your quote was liked!',
            'time' => now()->toDateTimeString(),
        ]);
    }
}
