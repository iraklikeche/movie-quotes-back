<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $verificationUrl = $this->verificationUrl($notifiable);
        // Just for Testing.
        return (new MailMessage())->view('email', ['url' => $verificationUrl, 'user' => $notifiable->username, 'headerText' => 'Verify your email address to get started', 'text' => "Thanks for joining Movie Quotes! We really appreciate it. Please click the button below to verify your account.   ", 'buttonText' => 'Verify account'])->from('no-reply@quizwiz.com')
        ->subject('Please verify your email');
    }

    protected function verificationUrl($notifiable)
    {


        $expires = config('auth.verification.expire', 60);

        $tempUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes($expires),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification()), 'email' => $notifiable->getEmailForVerification()]
        );

        $fullUrl = config('app.frontend_url') . '/?verify_url=' . urlencode($tempUrl);

        return $fullUrl;

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
