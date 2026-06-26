<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorOtp extends Notification
{
    use Queueable;

    public function __construct(
        public string $otp,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode OTP Reset Two-Factor Authentication')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Anda menerima email ini karena ada permintaan reset Two-Factor Authentication (2FA) pada akun Anda.')
            ->line('Berikut adalah kode OTP Anda:')
            ->line('**' . $this->otp . '**')
            ->line('Kode ini berlaku selama 10 menit.')
            ->line('Jika Anda tidak melakukan permintaan ini, abaikan email ini.')
            ->salutation('Salam, ' . config('app.name'));
    }
}
