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

        session(['checkout_voucher' => $request->voucher_id]);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
        ]);
    }

    public function handleSubmitRequest(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
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
        $discount = session('applied_voucher')['amount'] ?? 0;
        $finalAmount = $totalAmount + $shippingFee - $discount;

        session([
            'pending_checkout' => [
                'address_id' => $request->address_id,
                'shipping_method_id' => $shippingMethodId,
                'payment_method_id' => $paymentMethod->id,
                'total_amount' => $totalAmount,
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discount,
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