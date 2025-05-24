<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusNotification;

class OrderAdminController extends Controller
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

        return view('admin.pages.orders.index', compact('orders'));
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
            'payment.details',
            'orderItems.product',
            'orderItems.productVariant.attributeValues.attribute' // ✅ Load thêm thuộc tính
        ])->findOrFail($id);


        return view('admin.pages.orders.show', compact('order'));
    }

    /**
     * Hiển thị form cập nhật trạng thái.
     */
    // public function editStatus($id)
    // {
    //     $order = Order::findOrFail($id);
    //     return view('admin.pages.orders.edit-status', compact('order'));
    // }

    /**
     * Cập nhật trạng thái đơn hàng.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,completed,cancelled',
        ]);

        $order = Order::with('orderItems.productVariant', 'orderItems.product')->findOrFail($id);

        $current = $order->status;
        $next = $request->status;

        $validTransitions = [
            'pending' => ['confirmed'],
            'confirmed' => ['shipped'],
            'shipped' => ['delivered'],
            'delivered' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];

        if ($next === 'cancelled') {
            if (!in_array($current, ['pending', 'confirmed'])) {
                return back()->with('error', "Không thể hủy đơn hàng ở trạng thái '$current'.");
            }

            // Hoàn kho và ghi stock_logs
            foreach ($order->orderItems as $item) {
                if ($item->product_variant_id) {
                    $variant = $item->productVariant;
                    if ($variant) {
                        $before = $variant->stock_quantity;
                        $variant->increment('stock_quantity', $item->quantity);
                        $after = $variant->stock_quantity;

                        \App\Models\StockLog::create([
                            'product_id' => $item->product_id,
                            'variant_id' => $variant->id,
                            'admin_id' => auth()->id(), // nếu dùng guard riêng: auth('admin')->id()
                            'change_quantity' => $item->quantity,
                            'stock_before' => $before,
                            'stock_after' => $after,
                            'note' => 'Khôi phục tồn kho khi admin huỷ đơn #' . $order->order_code,
                        ]);
                    }
                } else {
                    $product = $item->product;
                    if ($product) {
                        $before = $product->quantity;
                        $product->increment('quantity', $item->quantity);
                        $after = $product->quantity;

                        \App\Models\StockLog::create([
                            'product_id' => $product->id,
                            'variant_id' => null,
                            'admin_id' => auth()->id(),
                            'change_quantity' => $item->quantity,
                            'stock_before' => $before,
                            'stock_after' => $after,
                            'note' => 'Khôi phục tồn kho khi admin huỷ đơn #' . $order->order_code,
                        ]);
                    }
                }
            }
        } elseif (!in_array($next, $validTransitions[$current] ?? [])) {
            return back()->with('error', "Không thể chuyển từ trạng thái '$current' sang '$next'.");
        }

        // Cập nhật trạng thái đơn hàng
        $order->update(['status' => $next]);

        // Gửi thông báo tới người dùng
        $order->user->notify(new OrderStatusNotification($order));

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