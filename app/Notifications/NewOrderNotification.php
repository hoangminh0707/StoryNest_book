<?php

namespace App\Notifications;


use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{


    /**
     * Create a new notification instance.
     */

    public $order;


    public function __construct($order)
    {
        $this->order = $order;
    }


    public function via($notifiable)
    {
        return ['mail', 'database']; // hoặc ['mail', 'database'] nếu muốn gửi email nữa
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🔔 Đơn hàng mới #' . $this->order->order_code)
            ->greeting('Xin chào Admin,')
            ->line('Có một đơn hàng mới từ khách hàng: ' . $this->order->user->name)
            ->line('Tổng tiền: ' . number_format($this->order->final_amount, 0, ',', '.') . 'đ')
            ->action('Xem chi tiết đơn hàng', url('/admin/orders/' . $this->order->id))
            ->line('Vui lòng kiểm tra đơn hàng sớm.');
    }

    public function toArray($notifiable)
    {
        $code = $this->order->order_code ?? 'Không rõ mã đơn hàng';
        $fullname = $this->order->full_name ?? 'Khách hàng';

        // Nếu chưa có quan hệ, tạm hiển thị 1 sản phẩm
        $productCount = $this->order->items()?->count() ?? 0;



        return [
            'title' => 'Đơn hàng mới',
            'message' => '#' . $code,
            'detail' => $fullname . ' đã đặt ' . $productCount . ' sản phẩm',
            'order_id' => $this->order->id,
            'url' => url('/admin/orders/' . $this->order->id),
        ];
    }

}