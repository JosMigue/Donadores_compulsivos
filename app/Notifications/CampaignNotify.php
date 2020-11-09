<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

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
        if($this->campaign->campaigntype == 'c1'){
            return (new MailMessage)
                ->subject(__('Notification of New campaign of Blood Donation'))
                ->line(__('You have received this email because there is a new Blood donation campaign.'))
                ->line(__('If you want give some ❤️ then, give click on button below "Yes, I want to donate"'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center"><img src="'.asset($this->campaign->campaign_image).'" width="150px" height="150px" alt=""></div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Information').'</div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Campaign name').': '.__($this->campaign->name).'</div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content: space-evenly;"><div style="display: flex; flex-flow: column;">'.__('Date').': '.$this->campaign->date_start.'</div><div style="display: flex; flex-flow: column;">     '.__('Time').': '.$this->campaign->time_start.'</div></div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Place').': '.$this->campaign->place.'</div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content: space-evenly;"><div style="display: flex; flex-flow: column;">'.__('State').': '.$this->campaign->state->name.'</div><div style="display: flex; flex-flow: column;">   '.__('City').': '.$this->campaign->city->name.'</div></div>'))
                ->action(__('Yes, I want to donate'), url('/campaigns/involve/'.$this->campaign->id.'/donor/'.$notifiable->id))
                ->line(__('Thank you for using our application!'));

        }else{
            return (new MailMessage)
                ->subject(__('Notification of New campaign of Blood Donation'))
                ->line(__('You have received this email because there is a new Blood donation campaign.'))
                ->line(__('If you want give some ❤️ then, give click on button below "Yes, I want to donate"'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center"><img src="'.asset($this->campaign->campaign_image).'" width="150px" height="150px" alt=""></div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Information').'</div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Campaign name').': '.__($this->campaign->name).'</div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content: space-evenly;"><div style="display: flex; flex-flow: column;">     '.__('Date').': '.$this->campaign->date_start.'</div><div style="display: flex; flex-flow: column;">       '. __('Time').': '.$this->campaign->time_start.'</div></div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Blood bank').': '.$this->campaign->bloodbank->name.'</div>'))
                ->line(new HtmlString('<div style="display:flex; flex-flow:row; justify-content:center">'.__('Blood bank address').': '.$this->campaign->bloodbank->address.'</div>'))
                ->action(__('Yes, I want to donate'), url('/campaigns/involve/'.$this->campaign->id.'/donor/'.$notifiable->id))
                ->line(__('Thank you for using our application!'));
        }
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
