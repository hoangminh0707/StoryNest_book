<?php

namespace App\Http\Controllers\Client\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\{Cart, PaymentMethod, ShippingMethod, Voucher};

trait HandlesCheckoutDisplay
{
    public function prepareCheckoutView()
    {
        $user = auth()->user();

        $addresses = $user->addresses;
        $defaultAddress = session('checkout_address_id')
            ? $addresses->where('id', session('checkout_address_id'))->first()
            : $addresses->where('is_default', 1)->first();

        if ($defaultAddress && !session()->has('checkout_address_id')) {
            session(['checkout_address_id' => $defaultAddress->id]);
        }

        $shippingMethods = ShippingMethod::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = $cart
            ? $cart->cartItems()->with(['product.categories', 'productVariant.attributeValues.attribute'])->get()
            : collect();

        $cartTotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $voucherData = $this->prepareVoucherData($user, $cartItems);

        $shippingFee = 0;
        $shipping = null;
        if (session()->has('checkout_shipping_method')) {
            $shipping = ShippingMethod::find(session('checkout_shipping_method'));
            $shippingFee = $shipping?->default_fee ?? 0;
        }

        $finalTotal = $cartTotal - $voucherData['discount'] + $shippingFee;

        return view('client.pages.checkout', [
            'addresses' => $addresses,
            'defaultAddress' => $defaultAddress,
            'shippingMethods' => $shippingMethods,
            'paymentMethods' => $paymentMethods,
            'cartItems' => $cartItems,
            'voucher' => $voucherData['voucher'],
            'vouchers' => $voucherData['vouchers'],
            'discount' => $voucherData['discount'],
            'eligibleProductIds' => $voucherData['eligibleProductIds'],
            'voucherApplicableTotal' => $voucherData['applicableTotal'],
            'shippingFee' => $shippingFee,
            'shipping' => $shipping,
            'payment' => session('checkout_payment_method') ? PaymentMethod::find(session('checkout_payment_method')) : null,
            'cartTotal' => $cartTotal,
            'finalTotal' => $finalTotal
        ]);
    }
}