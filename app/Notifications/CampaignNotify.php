<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignNotify extends Notification
{
    use Queueable;

    protected $user;
    protected $campaign;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($campaign)
    {
        $this->campaign = $campaign;
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
            ->subject(__('Notification of New campaign of Blood Donation'))
            ->line(__('You have received this email because there is a new Blood donation campaign.'))
            ->line(__('If you want give some ❤️ then, give click on button below "Yes, I want to donate"'))
            ->action(__('Yes, I want to donate'), url('/campaigns/involve/'.$this->campaign->id))
            ->line(__('Push the button for know more information about the campaign.'))
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
