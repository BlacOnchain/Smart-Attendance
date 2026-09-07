<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewDeviceLoginAlert extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $ip;
    public string $userAgent;
    public string $loggedInAt;

    /**
     * @param  \App\Models\User  $user
     * @param  string  $ip
     * @param  string|null  $userAgent
     * @param  \Carbon\Carbon|\Illuminate\Support\Carbon  $loggedInAt
     */
    public function __construct(User $user, string $ip, ?string $userAgent, $loggedInAt)
    {
        $this->user = $user;
        $this->ip = $ip;
        $this->userAgent = $userAgent ?? 'Unknown device';
        $this->loggedInAt = $loggedInAt->format('l, d M Y \a\t g:i A');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New sign-in to your Smart Attendance account',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-device-login',
            with: [
                'name' => $this->user->name,
                'ip' => $this->ip,
                'userAgent' => $this->userAgent,
                'loggedInAt' => $this->loggedInAt,
            ],
        );
    }
}