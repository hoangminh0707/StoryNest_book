<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAddress;
use App\Models\ShippingMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\cart;
use App\Models\CartItem;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentMethod;


class CheckoutClientController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Lấy tất cả địa chỉ của user
        $userAddresses = UserAddress::where('user_id', $user->id)->get();

        // Lấy các đơn vị vận chuyển đang hoạt động
        $shippingMethods = ShippingMethod::where('is_active', true)->get();

        $paymentMethods = PaymentMethod::where('is_active', true)->get();


        // Lấy giỏ hàng và các sản phẩm
        $cart = Cart::where('user_id', $user->id)->first();
        $cartItems = $cart ? $cart->cartItems()->with('product')->get() : collect();

        return view('client.pages.checkout', compact('userAddresses', 'shippingMethods', 'cartItems', 'paymentMethods'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method' => 'required|in:cod,bank',
        ]);

        $user = Auth::user();

        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();
        if (!$cart || $cart->cartItems->isEmpty()) {
            return back()->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Thử debug tại đây
        //    dd($cart->cartItems);

        DB::beginTransaction();

        try {
            $cartItems = $cart->cartItems;
            $shippingMethod = ShippingMethod::findOrFail($request->shipping_method_id);
            $shippingFee = $shippingMethod->default_fee;

            $totalProductAmount = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            $finalAmount = $totalProductAmount + $shippingFee;

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'user_address_id' => $request->address_id,
                'shipping_method_id' => $shippingMethod->id,
                'total_amount' => $totalProductAmount,
                'discount_amount' => 0, // xử lý sau nếu có voucher
                'shipping_fee' => $shippingFee,
                'final_amount' => $finalAmount,
                'status' => 'pending',
            ]);


            // Tạo các mục trong đơn hàng
            foreach ($cartItems as $item) {
                // Kiểm tra nếu sản phẩm không tồn tại (phòng lỗi null)
                if (!$item->product) {
                    throw new \Exception("Sản phẩm ID {$item->product_id} không tồn tại hoặc đã bị xóa.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'total' => $item->price * $item->quantity,
                ]);
            }

            // Sau khi tạo đơn hàng...
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $order->final_amount,
                'payment_method' => $request->payment_method,
                'status' => 'pending', // hoặc 'pending' nếu cần xác nhận
            ]);




            // Xóa giỏ hàng
            $cart->cartItems()->delete();
            $cart->delete();

            DB::commit();

            return redirect()->route('orders.success')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi khi đặt hàng: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.');
        }
    }

}