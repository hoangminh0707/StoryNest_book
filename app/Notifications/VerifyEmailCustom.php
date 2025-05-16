<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailCustom extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verifyUrl = $this->verificationUrl($notifiable);

                return (new MailMessage)
                    ->subject('Xác minh địa chỉ email')
                    ->greeting('Xin chào!')
                    ->line('Vui lòng nhấn vào nút bên dưới để xác minh địa chỉ email của bạn.')
                    ->action('Xác minh Email', $verifyUrl) // <- Đây là nút
                    ->line('Nếu bạn không yêu cầu tạo tài khoản, bạn có thể bỏ qua email này.')
                    ->salutation('Trân trọng, ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
