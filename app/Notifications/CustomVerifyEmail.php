<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;


class CustomVerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected function verificationUrl($notifiable){
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())] 
        );
    }
    public function toMail(object $notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $locale = $notifiable->language ?? app()->getLocale();
        if($locale === 'ha') {
            return (new MailMessage)
                        ->subject('Tabbatar da adireshin Imel qin ka')
                        ->greeting('Barka da war haka!')
                        ->line('ka danna maqallin da ke qasa don tabbtar da adireshin imel qin ka.')
                        ->action('Tabbatar da imel', $verificationUrl)
                        ->line('Idan ba ka qirqiri asusu ba, ka yi watsi da wannan saqon.')
                        ->salutation('Na gaishe ka, Shareni');
        }
        return (new MailMessage)
                    ->subject('Verify Your Email Address')
                    ->greeting('Hello!')
                    ->line('Please click the button below to verify your email address.')
                    ->action('Verify Email', $verificationUrl)
                    ->line('If you did not create an account, please ignore this email.')
                    ->salutation('Regards, Shareni');
    }
     public function via(object $notifiable): array
    {
        return ['mail'];
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
