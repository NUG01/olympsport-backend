<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetEmail;
use App\Mail\RegistrationEmail;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendVerificationEmail($name, $email, $url)
    {

        $data = [
            'name' => $name,
            'email' => $email,
            'url' => $url,
        ];

        Mail::to($email)->send(new RegistrationEmail($data));
    }
    public static function sendPasswordResetEmail($name, $email, $url)
    {

        $data = [
            'name' => $name,
            'email' => $email,
            'url' => $url,
        ];

        Mail::to($email)->send(new PasswordResetEmail($data));
    }
    public static  function sendUserMail($name, $email, $sms){

        $data = [
            'name' => $name,
            'email' => $email,
            'sms' => $sms,
        ];
        mail::to(env('MAIL_USERNAME'))->send(new UserMail($data));
    }
}
