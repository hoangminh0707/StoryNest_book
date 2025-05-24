<?php

namespace App\Http\Controllers\Client\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\{Order, OrderItem, Payment, Product, ProductVariant, StockLog, UserAddress, Voucher, ShippingMethod, PaymentMethod, Cart};
use App\Notifications\NewOrderNotification;
use App\Models\User;

trait HandlesOrderCreation
{
    protected function handleOrderCreationFromSession()
    {
        return $this->finalizeOrder('confirmed', 'completed');
    }

    protected function handleCODOrderCreation()
    {
        return $this->finalizeOrder('pending', 'pending');
    }

    private function finalizeOrder(string $orderStatus, string $paymentStatus)
    {
        $user = Auth::user();
        $pending = session('pending_checkout');

        if (!$pending) {
            return redirect()->route('checkout')->with('error', 'Không tìm thấy dữ liệu đặt hàng.');
        }

        DB::beginTransaction();

        try {
            $cart = Cart::with('cartItems.product.categories')->where('user_id', $user->id)->first();
            if (!$cart || $cart->cartItems->isEmpty()) {
                return redirect()->route('checkout')->with('error', 'Giỏ hàng rỗng.');
            }

            $cartItems = $cart->cartItems;
            $shippingMethod = ShippingMethod::findOrFail($pending['shipping_method_id']);
            $paymentMethod = PaymentMethod::findOrFail($pending['payment_method_id']);
            $shippingFee = $pending['shipping_fee'] ?? $shippingMethod->fee ?? 0;

            $totalProductAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            $discountAmount = 0;
            $voucherId = null;
            $logVoucher = null;

            $address = UserAddress::findOrFail($pending['address_id']);

            if (session()->has('checkout_voucher')) {
                $voucher = Voucher::with('conditions')->find(session('checkout_voucher'));
                $userUsed = DB::table('voucher_usage_logs')->where('voucher_id', $voucher->id)->where('user_id', $user->id)->exists();

                if ($voucher && !$userUsed && $voucher->is_active && (!$voucher->expires_at || $voucher->expires_at > now())) {
                    $discountAmount = (int) ($pending['discount_amount'] ?? 0);
                    $voucherId = $voucher->id;
                    $voucher->increment('usage_count');

                    $logVoucher = [
                        'voucher_id' => $voucher->id,
                        'user_id' => $user->id,
                        'discount_value' => $discountAmount,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            $finalAmount = $totalProductAmount - $discountAmount + $shippingFee;

            $order = Order::create([
                'order_code' => 'ORD' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'user_address' => $address->address_line . ', ' . $address->ward . ', ' . $address->district . ', ' . $address->city,
                'full_name' => $address->full_name,
                'phone' => $address->phone,
                'shipping_method_id' => $shippingMethod->id,
                'voucher_id' => $voucherId,
                'total_amount' => $totalProductAmount,
                'discount_amount' => $discountAmount,
                'shipping_fee' => $shippingFee,
                'final_amount' => $finalAmount,
                'status' => $orderStatus,
            ]);

            if ($logVoucher) {
                $logVoucher['order_id'] = $order->id;
                DB::table('voucher_usage_logs')->insert($logVoucher);
            }

            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if ($item->product_variant_id) {
                    $variant = ProductVariant::where('id', $item->product_variant_id)->lockForUpdate()->first();
                    if ($variant->stock_quantity < $item->quantity) {
                        throw new \Exception("Biến thể của sản phẩm '{$product->name}' không đủ hàng.");
                    }
                    $before = $variant->stock_quantity;
                    $variant->decrement('stock_quantity', $item->quantity);
                    $after = $before - $item->quantity;

                    StockLog::create([
                        'product_id' => $item->product_id,
                        'variant_id' => $item->product_variant_id,
                        'admin_id' => null,
                        'change_quantity' => -$item->quantity,
                        'stock_before' => $before,
                        'stock_after' => $after,
                        'note' => 'Đặt hàng - trừ kho ',
                    ]);
                } else {
                    if ($product->quantity < $item->quantity) {
                        throw new \Exception("Sản phẩm '{$product->name}' không đủ hàng.");
                    }
                    $before = $product->quantity;
                    $product->decrement('quantity', $item->quantity);
                    $after = $before - $item->quantity;

                    StockLog::create([
                        'product_id' => $item->product_id,
                        'variant_id' => null,
                        'admin_id' => null,
                        'change_quantity' => -$item->quantity,
                        'stock_before' => $before,
                        'stock_after' => $after,
                        'note' => 'Đặt hàng - trừ kho',
                    ]);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'amount' => $finalAmount,
                'payment_method' => $paymentMethod->id,
                'status' => $paymentStatus,
            ]);

            $cart->cartItems()->delete();
            $cart->delete();

            foreach (User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get() as $admin) {
                $admin->notify(new NewOrderNotification($order));
            }

            session()->forget(['checkout_voucher', 'checkout_shipping_method', 'checkout_address_id', 'pending_checkout']);

            DB::commit();

            return redirect()->route('orders.success')->with('success', 'Thanh toán và đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng.');
        }
    }
}