<?php

namespace App\Notifications;

use App\Models\Quote;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
        return ['database','broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'quote' => $this->quote,
            'user' => $this->user,
            'username' => $this->user->username,
            'image' => $this->user->profile_image_url,
            'message' => 'Reacted to your quote',
            'reacted' => true,
            'time' => Carbon::now(),
        ];
    }


    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'quote' => $this->quote,
            'user' => $this->user,
            'username' => $this->user->username,
            'image' => $this->user->profile_image_url,
            'message' => 'Reacted to your quote',
            'reacted' => true,
            'time' => Carbon::now(),
        ]);
    }

    public function broadcastOn()
    {
        return new Channel('App.Models.User.' . $this->quote->user_id);

    }

}
