<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;


class ReportEndDay extends Notification
{
    use Queueable;

    /**
     * @var Collection
     */
    private $questionsByRole;
    /**
     * @var Collection
     */
    private $questionByUsers;

    /**
     * Create a new notification instance.
     *
     * @param Collection $questionsByRole
     * @param Collection $questionByUsers
     */
    public function __construct(Collection $questionsByRole, Collection $questionByUsers)
    {
        $this->questionsByRole = $questionsByRole;
        $this->questionByUsers = $questionByUsers;
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
            ->subject("Tasktok - Relatório final de dia - Rede: {$notifiable->networks->first()->descricao}")
            ->from('noreply@tasktok.com', 'Tasktok')
            ->markdown('mail.reports.reportEndDay', [
                'url' => $url,
                'user'=>$notifiable,
                'questionsByRole'=>$this->questionsByRole,
                'questionByUsers'=>$this->questionByUsers,
            ]);
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
