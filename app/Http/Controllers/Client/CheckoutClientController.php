<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\NewOrderNotification;
use App\Models\{UserAddress, ShippingMethod, Order, OrderItem, Cart, CartItem, Payment, PaymentDetail, PaymentMethod, Voucher, VoucherCondition, Product, ProductVariant, User, StockLog};

use App\Http\Controllers\Client\Traits\HandlesCheckoutDisplay;
use App\Http\Controllers\Client\Traits\HandlesVoucherSelection;
use App\Http\Controllers\Client\Traits\HandlesOrderCreation;
use App\Http\Controllers\Client\Traits\HandlesSessionUpdates;

class CheckoutClientController extends Controller
{

    use HandlesCheckoutDisplay,
        HandlesVoucherSelection,
        HandlesOrderCreation,
        HandlesSessionUpdates;


    public function show()
    {
        return $this->prepareCheckoutView();
    }

    public function submit(Request $request)
    {
        return $this->handleSubmitRequest($request);
    }

    public function createOrderFromSession()
    {
        return $this->handleOrderCreationFromSession();
    }

    public function createOrder()
    {
        return $this->handleCODOrderCreation();
    }

    public function updateAddress(Request $request)
    {
        return $this->handleUpdateAddress($request);
    }

    public function updateShipping(Request $request)
    {
        return $this->handleUpdateShipping($request);
    }

    public function updatePayment(Request $request)
    {
        return $this->handleUpdatePayment($request);
    }

    public function updateVoucher(Request $request)
    {
        return $this->handleUpdateVoucher($request);
    }

    protected function generateOrderCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}