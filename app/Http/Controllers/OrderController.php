<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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
    $order = Order::with(['orderItems', 'userAddress', 'shippingMethod', 'payment'])->findOrFail($id);

    return view('client.pages.orders.show', compact('order'));
}



    public function success()
    {
            return view('client.pages.orders.success');
    }
}
