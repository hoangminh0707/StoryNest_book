<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\UserAddress;
use App\Models\ShippingMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\cart;
use App\Models\CartItem;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentMethod;
use App\Models\Voucher;
use App\Models\VoucherCondition;
use App\Models\Product;
use App\Models\ProductVariant;





class CheckoutClientController extends Controller
{
    public function show()
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
        $voucher = null;
        $discount = 0;
        $voucherApplicableTotal = 0;
        $finalTotal = $cartTotal;
        $shippingFee = 0;
        $shipping = null;
        $payment = null;

        if (session()->has('checkout_payment_method')) {
            $payment = PaymentMethod::find(session('checkout_payment_method'));
        }

        // Lấy toàn bộ product & category id trong giỏ
        $productIds = $cartItems->pluck('product_id')->toArray();
        $categoryIds = $cartItems->flatMap(fn($item) => $item->product->categories->pluck('id'))->unique()->toArray();

        // ✅ Lọc voucher chưa dùng + đúng điều kiện
        $vouchers = Voucher::with('conditions')
            ->where('is_active', 1)
            ->where(function ($q) use ($productIds, $categoryIds) {
                $q->whereDoesntHave('conditions')
                    ->orWhereHas('conditions', function ($cond) use ($productIds, $categoryIds) {
                        $cond->where(function ($inner) use ($productIds) {
                            $inner->where('condition_type', 'product')->whereIn('product_id', $productIds);
                        })
                            ->orWhere(function ($inner) use ($categoryIds) {
                                $inner->where('condition_type', 'category')->whereIn('category_id', $categoryIds);
                            })
                            ->orWhere(function ($inner) use ($productIds, $categoryIds) {
                                $inner->where('condition_type', 'product & category')
                                    ->where(function ($q2) use ($productIds) {
                                        $q2->whereIn('product_id', $productIds)->orWhereNull('product_id');
                                    })
                                    ->where(function ($q2) use ($categoryIds) {
                                        $q2->whereIn('category_id', $categoryIds)->orWhereNull('category_id');
                                    });
                            });
                    });
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->whereDoesntHave('usageLogs', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();

        $eligibleProductIds = collect();

        // Áp dụng voucher nếu có
        if (session()->has('checkout_voucher')) {
            $voucher = Voucher::with('conditions')->find(session('checkout_voucher'));

            if (
                $voucher &&
                $voucher->is_active &&
                (is_null($voucher->expires_at) || $voucher->expires_at > now()) &&
                (is_null($voucher->max_usage) || $voucher->usage_count < $voucher->max_usage)
            ) {
                foreach ($voucher->conditions as $cond) {
                    if ($cond->condition_type === 'product' && $cond->product_id) {
                        $eligibleProductIds->push($cond->product_id);
                    } elseif ($cond->condition_type === 'category' && $cond->category_id) {
                        $eligibleProductIds = $eligibleProductIds->merge(
                            $cartItems->filter(function ($item) use ($cond) {
                                return $item->product->categories->pluck('id')->contains($cond->category_id);
                            })->pluck('product_id')
                        );
                    } elseif ($cond->condition_type === 'null') {
                        $eligibleProductIds = $eligibleProductIds->merge(
                            $cartItems->filter(function ($item) use ($cond) {
                                $matchProduct = !$cond->product_id || $item->product_id == $cond->product_id;
                                $matchCategory = !$cond->category_id || $item->product->categories->pluck('id')->contains($cond->category_id);
                                return $matchProduct && $matchCategory;
                            })->pluck('product_id')
                        );
                    }
                }

                if ($voucher->conditions->isEmpty()) {
                    $eligibleProductIds = collect($productIds);
                }

                $eligibleProductIds = $eligibleProductIds->unique();

                $voucherApplicableTotal = $cartItems
                    ->whereIn('product_id', $eligibleProductIds)
                    ->sum(fn($item) => $item->price * $item->quantity);

                if ($voucherApplicableTotal >= $voucher->min_order_value) {
                    if ($voucher->type === 'percent') {
                        $discount = (int) round(min(
                            $voucherApplicableTotal * ($voucher->value / 100),
                            $voucher->max_discount_amount ?? INF
                        ));
                    } elseif ($voucher->type === 'fixed') {
                        $discount = min((int) $voucher->value, $voucherApplicableTotal);
                    }

                    $finalTotal = $cartTotal - $discount;
                }
            }
        }

        if (session()->has('checkout_shipping_method')) {
            $shipping = ShippingMethod::find(session('checkout_shipping_method'));
            if ($shipping) {
                $shippingFee = $shipping->default_fee;
            }
        }

        $finalTotal += $shippingFee;

        return view('client.pages.checkout', compact(
            'addresses',
            'defaultAddress',
            'shippingMethods',
            'paymentMethods',
            'cartItems',
            'voucher',
            'vouchers',
            'discount',
            'finalTotal',
            'eligibleProductIds',
            'shippingFee',
            'shipping',
            'payment'
        ));
    }



    protected function generateOrderCode(): string
    {
        do {
            // Tạo chuỗi gồm 8 ký tự: A-Z, 0-9
            $code = strtoupper(Str::random(8));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }



    public function submit(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
            'payment_method' => 'required|exists:payment_methods,id',
        ], [
            'address_id.required' => 'Vui lòng chọn địa chỉ giao hàng.',
            'address_id.exists' => 'Địa chỉ không hợp lệ.',

            'shipping_method_id.required' => 'Vui lòng chọn phương thức giao hàng.',
            'shipping_method_id.exists' => 'Phương thức giao hàng không hợp lệ.',

            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.exists' => 'Phương thức thanh toán không hợp lệ.',
        ]);


        $paymentMethod = PaymentMethod::findOrFail($request->payment_method);

        // ✅ Lấy giỏ hàng từ session hoặc package Cart
        // Lấy cart của user hiện tại
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $cartItems = CartItem::where('cart_id', $cart->id)->get();

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $shippingMethodId = session('checkout_shipping_method') ?? $request->shipping_method_id;

        $shippingMethod = ShippingMethod::find($shippingMethodId);

        if (!$shippingMethod) {
            return redirect()->route('checkout')->with('error', 'Phương thức giao hàng không hợp lệ.');
        }

        $shippingFee = $shippingMethod->default_fee ?? 0;

        // ✅ Giảm giá (nếu có áp dụng voucher)
        $discount = 0;
        if (session('applied_voucher')) {
            $discount = session('applied_voucher')['amount'] ?? 0;
        }

        // ✅ Tính tổng tiền cuối cùng
        $finalAmount = $totalAmount + $shippingFee - $discount;

        // ✅ Lưu session chuẩn để tạo đơn sau thanh toán
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


        // ✅ Điều hướng theo phương thức thanh toán
        if ($paymentMethod->code === 'bank') {
            return redirect()->route('vnpay.payment');
        }

        if ($paymentMethod->code === 'momo') {
            return redirect()->route('momo.payment');
        }

        // ✅ Nếu là thanh toán COD
        return $this->createOrder();
    }




    public function createOrderFromSession()
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
                    $eligibleProductIds = collect();

                    foreach ($voucher->conditions as $cond) {
                        if ($cond->condition_type === 'product' && $cond->product_id) {
                            $eligibleProductIds->push($cond->product_id);
                        } elseif ($cond->condition_type === 'category' && $cond->category_id) {
                            $eligibleProductIds = $eligibleProductIds->merge(
                                $cartItems->filter(fn($item) => $item->product->categories->pluck('id')->contains($cond->category_id))
                                    ->pluck('product_id')
                            );
                        }
                    }

                    if ($voucher->conditions->isEmpty()) {
                        $eligibleProductIds = $cartItems->pluck('product_id');
                    }

                    $eligibleProductIds = $eligibleProductIds->unique();
                    $voucherTotal = $cartItems->whereIn('product_id', $eligibleProductIds)->sum(fn($item) => $item->price * $item->quantity);

                    if ($voucherTotal >= $voucher->min_order_value) {
                        $discountAmount = $voucher->type === 'percent'
                            ? (int) round(min($voucherTotal * ($voucher->value / 100), $voucher->max_discount_amount ?? INF))
                            : min((int) $voucher->value, $voucherTotal);

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
                'status' => 'confirmed',
            ]);

            if ($logVoucher) {
                $logVoucher['order_id'] = $order->id;
                DB::table('voucher_usage_logs')->insert($logVoucher);
            }

            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if ($product->quantity < $item->quantity) {
                    throw new \Exception("Sản phẩm '{$product->name}' không đủ hàng.");
                }

                if ($item->product_variant_id) {
                    $variant = ProductVariant::where('id', $item->product_variant_id)->lockForUpdate()->first();

                    if ($variant->stock_quantity < $item->quantity) {
                        throw new \Exception("Biến thể của sản phẩm '{$product->name}' không đủ hàng.");
                    }

                    $variant->decrement('stock_quantity', $item->quantity);
                }

                $product->decrement('quantity', $item->quantity);

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
                'payment_method' => $paymentMethod->id, // ✅ đúng kiểu INT
                'status' => 'completed', // theo đúng ENUM
            ]);

            $cart->cartItems()->delete();
            $cart->delete();

            session()->forget(['checkout_voucher', 'checkout_shipping_method', 'checkout_address_id', 'pending_checkout']);

            DB::commit();

            return redirect()->route('orders.success')->with('success', 'Thanh toán và đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi khi xử lý đơn sau thanh toán ONLINE: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng sau thanh toán.');
        }
    }


    public function createOrder()
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
                    $eligibleProductIds = collect();

                    foreach ($voucher->conditions as $cond) {
                        if ($cond->condition_type === 'product' && $cond->product_id) {
                            $eligibleProductIds->push($cond->product_id);
                        } elseif ($cond->condition_type === 'category' && $cond->category_id) {
                            $eligibleProductIds = $eligibleProductIds->merge(
                                $cartItems->filter(fn($item) => $item->product->categories->pluck('id')->contains($cond->category_id))
                                    ->pluck('product_id')
                            );
                        }
                    }

                    if ($voucher->conditions->isEmpty()) {
                        $eligibleProductIds = $cartItems->pluck('product_id');
                    }

                    $eligibleProductIds = $eligibleProductIds->unique();
                    $voucherTotal = $cartItems->whereIn('product_id', $eligibleProductIds)->sum(fn($item) => $item->price * $item->quantity);

                    if ($voucherTotal >= $voucher->min_order_value) {
                        $discountAmount = $voucher->type === 'percent'
                            ? (int) round(min($voucherTotal * ($voucher->value / 100), $voucher->max_discount_amount ?? INF))
                            : min((int) $voucher->value, $voucherTotal);

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
                'status' => 'pending',
            ]);

            if ($logVoucher) {
                $logVoucher['order_id'] = $order->id;
                DB::table('voucher_usage_logs')->insert($logVoucher);
            }

            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                if ($product->quantity < $item->quantity) {
                    throw new \Exception("Sản phẩm '{$product->name}' không đủ hàng.");
                }

                if ($item->product_variant_id) {
                    $variant = ProductVariant::where('id', $item->product_variant_id)->lockForUpdate()->first();

                    if ($variant->stock_quantity < $item->quantity) {
                        throw new \Exception("Biến thể của sản phẩm '{$product->name}' không đủ hàng.");
                    }

                    $variant->decrement('stock_quantity', $item->quantity);
                }

                $product->decrement('quantity', $item->quantity);

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
                'payment_method' => $paymentMethod->id, // ✅ đúng kiểu INT
                'status' => 'pending', // theo đúng ENUM
            ]);

            $cart->cartItems()->delete();
            $cart->delete();

            session()->forget(['checkout_voucher', 'checkout_shipping_method', 'checkout_address_id', 'pending_checkout']);

            DB::commit();

            return redirect()->route('orders.success')->with('success', 'Thanh toán và đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi khi xử lý đơn sau thanh toán COD: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Đã xảy ra lỗi khi xử lý đơn hàng sau thanh toán.');
        }
    }


    public function updateAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        session(['checkout_address_id' => $request->address_id]);

        return response()->json(['success' => true]);
    }

    public function updateShipping(Request $request)
    {
        $request->validate([
            'shipping_id' => 'required|exists:shipping_methods,id',
        ]);

        session(['checkout_shipping_method' => $request->shipping_id]);

        return response()->json(['success' => true]);
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:payment_methods,id',
        ]);

        session(['checkout_payment_method' => $request->payment_id]);

        return response()->json(['success' => true]);
    }

    public function updateVoucher(Request $request)
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


}