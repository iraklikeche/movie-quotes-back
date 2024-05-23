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

    /**
     * Create a new notification instance.
     */
    public function __construct(Quote $quote)
    {
        $this->quote = $quote;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'quote_id' => $this->quote->id,
            'message' => 'Your quote was liked!232323',
        ];
    }

    public function toBroadcast($notifiable)
    {
        $data = [
            'quote_id' => $this->quote->id,
            'message' => 'Your quote was liked!434343',
        ];


        return new BroadcastMessage($data);
    }

}
