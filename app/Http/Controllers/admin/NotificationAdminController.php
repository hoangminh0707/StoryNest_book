<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationAdminController extends Controller
{
    public function fetch()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->limit(10)->latest()->get();

        return response()->json([
            'count' => $user->unreadNotifications()->count(),
            'notifications' => $notifications->map(function ($n) {
                return [
                    'title' => $n->data['title'] ?? 'Thông báo',
                    'message' => $n->data['message'] ?? '',
                    'detail' => $n->data['detail'] ?? '', // ✅ thêm dòng này
                    'url' => $n->data['url'] ?? '#',
                    'time' => $n->created_at->diffForHumans(),
                ];
            })

        ]);
    }


    public function fetchUserNotifications()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->take(10)->get();


        $data = $notifications->map(function ($noti) {
            $orderId = $noti->data['order_id'] ?? null;
            $order = \App\Models\Order::with('orderItems.product.thumbnail')->find($orderId);


            $firstImage = 'images/default.jpg'; // fallback nằm ở public/images

            if ($order && $order->orderItems->isNotEmpty()) {
                $product = $order->orderItems->first()->product;

                $thumbnail = $product->thumbnail; // lấy ảnh chính

                if ($thumbnail && $thumbnail->image_path && file_exists(storage_path('app/public/' . $thumbnail->image_path))) {
                    $firstImage = 'storage/' . $thumbnail->image_path;
                }
            }

            return [
                'title' => 'Cập nhật đơn hàng #' . ($order->order_code ?? '...'),
                'message' => $noti->data['message'] ?? '',
                'detail' => $noti->data['status_label'] ?? '',
                'url' => route('orders.show', $orderId),
                'time' => $noti->created_at->diffForHumans(),
                'image' => asset($firstImage),
            ];
        });


        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $data,
        ]);
    }


}