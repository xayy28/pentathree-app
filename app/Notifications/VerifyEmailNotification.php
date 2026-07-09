<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends VerifyEmail
{
    use Queueable;

    /**
     * Build the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verifikasi Alamat Email Anda — Natasha Homestay')
            ->greeting('Halo, ' . $notifiable->nama . '!')
            ->line('Terima kasih telah mendaftar di **Natasha Homestay**.')
            ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda dan mulai menikmati seluruh fitur yang tersedia.')
            ->action('Verifikasi Email Saya', $verificationUrl)
            ->line('Link verifikasi ini akan kedaluwarsa dalam ' . (Config::get('auth.verification.expire', 60)) . ' menit.')
            ->line('Jika Anda tidak merasa membuat akun ini, Anda dapat mengabaikan email ini.')
            ->salutation('Salam hangat, Tim Natasha Homestay');
    }

    /**
     * Generate signed verification URL menggunakan primary key kustom user_id.
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
