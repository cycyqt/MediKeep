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
        $message = new MailMessage;

        switch ($this->type) {
            case 'created':
                $message->line('Your account has been successfully created and is awaiting approval.');
                break;
            case 'archived':
                $message->line('Your account has been temporarily disabled.');
                break;
            case 'deleted':
                $message->line('Your account has been permanently deleted.');
                break;
            case 'status':
                if ($this->status === 'approved') {
                    $message->line('Your status has been approved.');
                } else if ($this->status === 'rejected') {
                    $message->line('Your status has been rejected.');
                }
                break;
        }

        return $message;
    }
}