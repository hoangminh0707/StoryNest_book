<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class WishlistClientController extends Controller
{

    public function index()
    {

        $wishlistItems = Wishlist::with(['product.variants', 'product.images'])
            ->where('user_id', Auth::id())
            ->get();




        return view('client.pages.wishlist', compact('wishlistItems'));
    }

    public function add($productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để sử dụng chức năng yêu thích.');
        }

        $wishlist = Wishlist::firstOrCreate([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
        ]);

        if ($wishlist->wasRecentlyCreated) {
            return redirect()->back()->with('success', 'Đã thêm vào danh sách yêu thích!');
        } else {
            return redirect()->back()->with('error', 'Sản phẩm đã có trong danh sách yêu thích.');
        }
    }


    public function remove($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return redirect()->back()->with('success', 'Đã xóa khỏi yêu thích!');
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('client.pages.product', compact('product'));
    }
}
