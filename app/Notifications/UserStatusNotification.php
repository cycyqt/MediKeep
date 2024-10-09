<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param string $status
     * @param string $type
     */
    public function __construct($status, $type)
    {
        $this->status = $status;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new \App\Mail\UserStatusMailable($this->status, $this->type, $notifiable))
                    ->to($notifiable->email);
    }

}