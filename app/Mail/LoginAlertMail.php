<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $ipAddress;
    public string $userAgent;
    public string $loginTime;

    public function __construct(User $user, string $ipAddress, string $userAgent, string $loginTime)
    {
        $this->user = $user;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->loginTime = $loginTime;
    }

    public function build()
    {
        return $this->subject('New Login to Your Smart Attendance Account')
            ->view('emails.login-alert');
    }
}