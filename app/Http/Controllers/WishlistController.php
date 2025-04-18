<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{

public function add($productId)
{
    if (!Auth::check()) return redirect()->route('login');

    Wishlist::firstOrCreate([
        'user_id' => Auth::id(),
        'product_id' => $productId,
    ]);

    return redirect()->back()->with('success', 'Đã thêm vào yêu thích!');
}

public function remove($productId)
{
    Wishlist::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->delete();

    return redirect()->back()->with('success', 'Đã xóa khỏi yêu thích!');
}


}
