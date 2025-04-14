<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product.images']) // thêm images
            ->where('user_id', Auth::id())
            ->first();

            $query = Product::with(['author', 'images' => function($query) {
                $query->where('is_thumbnail', true);
            }]);

            $products = $query->paginate(12);
        $cartItems = $cart ? $cart->items : collect();
        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);
    
        return view('client.pages.cart', compact('cartItems', 'total','products'));
    }

    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['redirect' => route('login')], 401);
        }
        $product = Product::findOrFail($id);
        $userId = Auth::id();
        $variantId = $request->input('product_variant_id');
        $quantity = $request->input('quantity', 1);
        $price = $request->input('price');
    
        // Tìm hoặc tạo cart cho user
        $cart = Cart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['created_at' => now(), 'updated_at' => now()]
        );
    
        // Tìm item trùng để cập nhật số lượng
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $product->id)
                        ->where('product_variant_id', $variantId)
                        ->first();
    
        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->input('quantity', 1),
                'price' => $product->price, // đảm bảo $product->price không null
            ]);
        }
        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Đã cập nhật giỏ hàng!');
    }

    public function remove($productId)
{
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Vui lòng đăng nhập.');
    }

    $cart = Cart::where('user_id', $user->id)->first();

    if ($cart) {
        CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->delete();
    }

    return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
}
}
