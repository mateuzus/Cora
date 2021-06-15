<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ListDaily extends Notification
{
    use Queueable;

    public $listingArray;
    /**
     * Create a new notification instance.
     *
     * @param array $listingArray
     */
    public function __construct(array $listingArray)
    {
        $this->listingArray = $listingArray;
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


        $url = url('/');

        return (new MailMessage())
            ->subject("Tasktok - Relatório Díário - Rede: {$notifiable->networks->first()->descricao}")
            ->from('noreply@tasktok.com', 'Tasktok')
            ->markdown('mail.reports.reportDaily', ['url' => $url, 'user'=>$notifiable,'listingArray'=>$this->listingArray]);
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
