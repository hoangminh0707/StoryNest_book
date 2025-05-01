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
        $orders = Order::with('orderItems')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('client.pages.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::with(['orderItems', 'userAddress', 'shippingMethod', 'payment.paymentMethod'])->findOrFail($id);

        return view('client.pages.orders.show', compact('order'));
    }



    public function success()
    {
        return view('client.pages.orders.success');
    }
}