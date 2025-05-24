<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderClientController extends Controller
{

    public function index()
    {
        $orders = Order::with([
            'orderItems.variant.attributeValues.attribute' // ✅ load sâu
        ])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('client.pages.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with([
            'orderItems.variant.attributeValues.attribute', // ✅ load thêm thông tin biến thể
            'userAddress',
            'shippingMethod',
            'payment.paymentMethod'
        ])->findOrFail($id);


        // Kiểm tra quyền truy cập
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');
        }

        return view('client.pages.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Không thể huỷ đơn hàng đã được giao hoặc huỷ trước đó.');
        }

        foreach ($order->orderItems as $item) {
            if ($item->product_variant_id) {
                // Biến thể
                $variant = \App\Models\ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $before = $variant->stock_quantity;
                    $variant->increment('stock_quantity', $item->quantity);
                    $after = $variant->stock_quantity;

                    // Ghi vào stock_logs
                    \App\Models\StockLog::create([
                        'product_id' => $item->product_id,
                        'variant_id' => $variant->id,
                        'admin_id' => auth()->id(), // hoặc null nếu người dùng thường
                        'change_quantity' => $item->quantity,
                        'stock_before' => $before,
                        'stock_after' => $after,
                        'note' => 'Khôi phục tồn kho khi huỷ đơn #' . $order->order_code,
                    ]);
                }
            } else {
                // Sản phẩm gốc
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $before = $product->quantity;
                    $product->increment('quantity', $item->quantity);
                    $after = $product->quantity;

                    // Ghi vào stock_logs
                    \App\Models\StockLog::create([
                        'product_id' => $product->id,
                        'variant_id' => null,
                        'admin_id' => auth()->id(), // hoặc null
                        'change_quantity' => $item->quantity,
                        'stock_before' => $before,
                        'stock_after' => $after,
                        'note' => 'Khôi phục tồn kho khi huỷ đơn #' . $order->order_code,
                    ]);
                }
            }
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('orders.show', $order->id)->with('success', 'Đơn hàng đã được huỷ và tồn kho đã được khôi phục.');
    }



    public function success()
    {
        return view('client.pages.orders.success');
    }
}