<?php

namespace App\Http\Controllers\Client\Traits;

use Illuminate\Http\Request;

trait HandlesSessionUpdates
{
    public function handleUpdateAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        session(['checkout_address_id' => $request->address_id]);

        return response()->json(['success' => true]);
    }

    public function handleUpdateShipping(Request $request)
    {
        $request->validate([
            'shipping_id' => 'required|exists:shipping_methods,id',
        ]);

        session(['checkout_shipping_method' => $request->shipping_id]);

        return response()->json(['success' => true]);
    }

    public function handleUpdatePayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payment_methods,id',
        ]);

        session(['checkout_payment_method' => $request->payment_id]);

        return response()->json(['success' => true]);
    }
    public function handleUpdateVoucher(Request $request)
    {
        $request->validate([
            'voucher_id' => 'nullable|exists:vouchers,id',
        ]);

        $voucherId = $request->voucher_id;
        session(['checkout_voucher' => $voucherId]);

        $user = auth()->user();
        $cart = \App\Models\Cart::where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->cartItems()->with(['product.categories'])->get() : collect();

        $discount = 0;

        if ($voucherId) {
            $voucher = \App\Models\Voucher::with('conditions')->find($voucherId);

            if ($voucher && $voucher->is_active && (!$voucher->expires_at || $voucher->expires_at > now())) {
                $eligibleProductIds = collect();

                foreach ($voucher->conditions as $cond) {
                    if ($cond->condition_type === 'product' && $cond->product_id) {
                        $eligibleProductIds->push($cond->product_id);
                    } elseif ($cond->condition_type === 'category' && $cond->category_id) {
                        $eligibleProductIds = $eligibleProductIds->merge(
                            $cartItems->filter(fn($item) => $item->product->categories->pluck('id')->contains($cond->category_id))->pluck('product_id')
                        );
                    }
                }

                if ($voucher->conditions->isEmpty()) {
                    $eligibleProductIds = $cartItems->pluck('product_id');
                }

                $eligibleProductIds = $eligibleProductIds->unique();

                $applicableTotal = $cartItems->whereIn('product_id', $eligibleProductIds)
                    ->sum(fn($item) => $item->price * $item->quantity);

                if ($applicableTotal >= $voucher->min_order_value) {
                    $discount = match ($voucher->type) {
                        'percent' => (int) round(min($applicableTotal * ($voucher->value / 100), $voucher->max_discount_amount ?? INF)),
                        'fixed' => min((int) $voucher->value, $applicableTotal),
                        default => 0,
                    };
                }
            }
        }

        // Cập nhật số tiền giảm và voucher_id vào session pending_checkout
        $pendingCheckout = session('pending_checkout', []);
        $pendingCheckout['discount_amount'] = $discount;
        $pendingCheckout['voucher_id'] = $voucherId;
        session(['pending_checkout' => $pendingCheckout]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount_amount' => $discount,
        ]);
    }


    public function handleSubmitRequest(Request $request)
    {
        // Kiểm tra thiếu lựa chọn và hiển thị lỗi ngay
        if (!$request->address_id) {
            return redirect()->route('checkout')->with('error', 'Vui lòng chọn địa chỉ giao hàng.');
        }

        if (!$request->shipping_method_id && !session('checkout_shipping_method')) {
            return redirect()->route('checkout')->with('error', 'Vui lòng chọn phương thức giao hàng.');
        }

        if (!$request->payment_method) {
            return redirect()->route('checkout')->with('error', 'Vui lòng chọn phương thức thanh toán.');
        }

        // Validate dữ liệu hợp lệ
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_method_id' => 'nullable|exists:shipping_methods,id',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        $paymentMethod = \App\Models\PaymentMethod::findOrFail($request->payment_method);
        $cart = \App\Models\Cart::where('user_id', auth()->id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $cartItems = $cart->cartItems;
        $totalAmount = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $shippingMethodId = session('checkout_shipping_method') ?? $request->shipping_method_id;
        $shippingMethod = \App\Models\ShippingMethod::find($shippingMethodId);

        if (!$shippingMethod) {
            return redirect()->route('checkout')->with('error', 'Phương thức giao hàng không hợp lệ.');
        }

        $shippingFee = $shippingMethod->default_fee ?? 0;

        // 🔧 SỬA: Lấy discount từ đúng session key
        $discount = 0;
        $voucherId = null;

        // Lấy từ pending_checkout nếu có
        $pendingCheckout = session('pending_checkout', []);
        if (isset($pendingCheckout['discount_amount'])) {
            $discount = $pendingCheckout['discount_amount'];
            $voucherId = $pendingCheckout['voucher_id'] ?? null;
        } else {
            // Hoặc tính lại nếu có voucher trong session
            if (session()->has('checkout_voucher')) {
                $voucher = \App\Models\Voucher::with('conditions')->find(session('checkout_voucher'));
                if ($voucher && $voucher->is_active && (!$voucher->expires_at || $voucher->expires_at > now())) {
                    // Tính lại discount (copy logic từ HandlesVoucherSelection)
                    $eligibleProductIds = collect();

                    foreach ($voucher->conditions as $cond) {
                        if ($cond->condition_type === 'product' && $cond->product_id) {
                            $eligibleProductIds->push($cond->product_id);
                        } elseif ($cond->condition_type === 'category' && $cond->category_id) {
                            $eligibleProductIds = $eligibleProductIds->merge(
                                $cartItems->filter(fn($item) => $item->product->categories->pluck('id')->contains($cond->category_id))->pluck('product_id')
                            );
                        }
                    }

                    if ($voucher->conditions->isEmpty()) {
                        $eligibleProductIds = $cartItems->pluck('product_id');
                    }

                    $eligibleProductIds = $eligibleProductIds->unique();
                    $applicableTotal = $cartItems->whereIn('product_id', $eligibleProductIds)
                        ->sum(fn($item) => $item->price * $item->quantity);

                    if ($applicableTotal >= $voucher->min_order_value) {
                        $discount = match ($voucher->type) {
                            'percent' => (int) round(min($applicableTotal * ($voucher->value / 100), $voucher->max_discount_amount ?? INF)),
                            'fixed' => min((int) $voucher->value, $applicableTotal),
                            default => 0,
                        };
                    }

                    $voucherId = $voucher->id;
                }
            }
        }

        $finalAmount = $totalAmount + $shippingFee - $discount;

        session([
            'pending_checkout' => [
                'address_id' => $request->address_id,
                'shipping_method_id' => $shippingMethodId,
                'payment_method_id' => $paymentMethod->id,
                'total_amount' => $totalAmount,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discount, // 🔧 Đảm bảo discount được lưu đúng
                'voucher_id' => $voucherId,     // 🔧 Thêm voucher_id
                'final_amount' => $finalAmount
            ]
        ]);

        return match ($paymentMethod->code) {
            'bank' => redirect()->route('vnpay.payment'),
            'momo' => redirect()->route('momo.payment'),
            default => $this->handleCODOrderCreation(),
        };
    }

}