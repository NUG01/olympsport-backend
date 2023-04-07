<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build(): PasswordResetEmail
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Password reset')
            ->view('mail.passwordReset', ['name' => $this->data['name'], 'email' => $this->data['email'], 'url' => $this->data['url']]);
    }
}
