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
}