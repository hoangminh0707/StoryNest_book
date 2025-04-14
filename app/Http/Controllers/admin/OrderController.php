<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Danh sách đơn hàng (với tìm kiếm, filter).
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'userAddress', 'voucher', 'shippingMethod'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
        }

        $orders = $query->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Xem chi tiết đơn hàng.
     */
    public function show($id)
    {
        $order = Order::with([
            'user',
            'userAddress',
            'voucher',
            'shippingMethod',
            'orderItems.product',
            'orderItems.productVariant',
            'payment.details'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Hiển thị form cập nhật trạng thái.
     */
    public function editStatus($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit-status', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')->with('success', 'Cập nhật trạng thái thành công.');
    }

    /**
     * Xóa đơn hàng.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công.');
    }
}
