<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserStatusMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $type;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $status
     * @param string $type
     * @param object $user
     */
    public function __construct($status, $type, $user)
    {
        $this->status = $status;
        $this->type = $type;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('notification.email')
            ->with([
                'status' => $this->status,
                'type' => $this->type,
                'user' => $this->user
            ])
            ->subject('Your Account Status Update')
            ->from('no-reply@medikeep.com', 'Carl Ceo OF MediKeep');
    }
}
