<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTurnDonation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $currentTurn;
    public function __construct($currentTurn)
    {
        $this->currentTurn = $currentTurn;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(__('Notification of register on campaign'))
                    ->line(__('You have received this email because You just checked in on one campaign'))
                    ->line(__('Your turn is at: ') . $this->currentTurn)
                    ->line(__('Remind that you have to arrive some minutes before your turn'))
                    ->line(__('If you want to know more information about what to do before you donate please click on button below'))
                    ->action(__('Information'), url(''))
                    ->line(__('Thank you for using our application!'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
