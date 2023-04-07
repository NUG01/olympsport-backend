<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build(): UserMail
    {
        return $this->from($this->user['email'])->to(env('MAIL_USERNAME'))
            ->subject($this->user['sms'])
            ->view('mail.userMail', ['name' => $this->user['name'], 'email' => $this->user['email'], 'sms' => $this->user['sms']]);
    }
}
