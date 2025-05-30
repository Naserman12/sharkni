<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class rentalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $rental;
    public function __construct($rental)
    {
        $this->rental = $rental;
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
     * Get the mail representation of the notification.
     */
     public function toDatabase(){
      
       return new DatabaseMessage([
         'message' => app()->getLocale() == 'ha' ? 'An samu sabon neman aro akan kayan aikin ka: #{$this->rental->tool_id} .' : 'You have a new borrow request for your tool: #{$this->rental->tool_id}.',
         'url' => route('rentals.index'),
       ]);
    }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
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
            //
        ];
    }
}
