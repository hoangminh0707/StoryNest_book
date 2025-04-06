<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        $orders = Order::with('items')->get(); // Lấy tất cả đơn hàng cùng với các sản phẩm trong đơn
        return view('admin.order.list', compact('orders'));
    }

    // Chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('admin.order.detail', compact('order'));
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('listOrders')->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}

