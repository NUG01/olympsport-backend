<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build(): RegistrationEmail
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Email Verification')
            ->view('mail.register', ['name' => $this->data['name'], 'email' => $this->data['email'], 'url' => $this->data['url']]);
    }
}
