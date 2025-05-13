<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class OrderStatusNotification extends Notification
{

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    protected function getStatusLabel($status)
    {
        $map = [
            'pending' => 'đang chờ xác nhận',
            'confirmed' => 'Đã được xác nhận',
            'shipped' => 'Đang giao',
            'delivered' => 'Đã giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        return $map[$status] ?? ucfirst($status);
    }


    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'order_code' => $this->order->order_code,
            'status_label' => ucfirst($this->order->status),
            'message' => "Đơn hàng của bạn " . $this->getStatusLabel($this->order->status),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}