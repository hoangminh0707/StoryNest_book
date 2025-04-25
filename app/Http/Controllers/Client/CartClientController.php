<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class CartClientController extends Controller
{
    public function index()
    {
        $cart = Cart::with(['items.product.images']) // thêm images
            ->where('user_id', Auth::id())
            ->first();

        $query = Product::with([
            'author',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ]);

        $products = $query->paginate(12);
        $cartItems = $cart ? $cart->items : collect();
        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        return view('client.pages.cart', compact('cartItems', 'total', 'products'));
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

        // Nếu có variant, dùng giá của variant
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price = $variant->variant_price;
        } else {
            $price = $product->price;
        }

        // Tìm hoặc tạo giỏ hàng
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // Kiểm tra item trùng (cùng product và variant)
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
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'price' => $price,
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity = $request->quantity;
            $item->save();
        }

        return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật.');
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