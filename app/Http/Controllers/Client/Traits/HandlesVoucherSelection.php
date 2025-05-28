<?php

namespace App\Http\Controllers\Client\Traits;

use App\Models\{Voucher};

trait HandlesVoucherSelection
{
    protected function prepareVoucherData($user, $cartItems)
    {
        $productIds = $cartItems->pluck('product_id')->toArray();
        $categoryIds = $cartItems->flatMap(fn($item) => $item->product->categories->pluck('id'))->unique()->toArray();

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

        if (!session()->has('checkout_voucher')) {
            $priceMap = $cartItems->mapWithKeys(fn($item) => [$item->product_id => $item->price * $item->quantity]);

            $bestVoucherObj = $vouchers->map(function ($v) use ($priceMap, $cartItems) {
                $applicableProductIds = collect();

                foreach ($v->conditions as $cond) {
                    if ($cond->condition_type === 'product' && $cond->product_id) {
                        $applicableProductIds->push($cond->product_id);
                    } elseif ($cond->condition_type === 'category' && $cond->category_id) {
                        $applicableProductIds = $applicableProductIds->merge(
                            $cartItems->filter(function ($item) use ($cond) {
                                return $item->product->categories->pluck('id')->contains($cond->category_id);
                            })->pluck('product_id')
                        );
                    }
                }

                if ($v->conditions->isEmpty()) {
                    $applicableProductIds = $cartItems->pluck('product_id');
                }

                $total = $priceMap->only($applicableProductIds->unique()->all())->sum();
                if ($total < $v->min_order_value)
                    return null;

                $discount = 0;
                if ($v->type === 'percent') {
                    $discount = min($total * ($v->value / 100), $v->max_discount_amount ?? INF);
                } elseif ($v->type === 'fixed') {
                    $discount = min($v->value, $total);
                }

                return (object) [
                    'voucher' => $v,
                    'discount' => $discount,
                ];
            })->filter()->sortByDesc('discount')->first();

            if ($bestVoucherObj) {
                session(['checkout_voucher' => $bestVoucherObj->voucher->id]);
            }
        }

        $voucher = null;
        $discount = 0;
        $eligibleProductIds = collect();
        $applicableTotal = 0;

        if (session()->has('checkout_voucher')) {
            $voucher = Voucher::with('conditions')->find(session('checkout_voucher'));

            if ($voucher && $voucher->is_active && (!$voucher->expires_at || $voucher->expires_at > now())) {
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
                    $eligibleProductIds = collect($productIds);
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

            // Cập nhật số tiền giảm và voucher_id vào session pending_checkout
            $pendingCheckout = session('pending_checkout', []);
            $pendingCheckout['discount_amount'] = $discount;
            $pendingCheckout['voucher_id'] = $voucher ? $voucher->id : null;
            session(['pending_checkout' => $pendingCheckout]);
        }

        return [
            'voucher' => $voucher,
            'vouchers' => $vouchers,
            'discount' => $discount,
            'eligibleProductIds' => $eligibleProductIds,
            'applicableTotal' => $applicableTotal,
        ];
    }
}