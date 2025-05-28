<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\Wishlist;
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
        $variantId = $request->input('variant_id');
        $quantity = $request->input('quantity', 1);

        // ✅ KIỂM TRA TRẠNG THÁI SẢN PHẨM
        if ($product->status == 0 || $product->status == 'discontinued') { // Điều chỉnh theo cấu trúc DB của bạn
            return redirect()->back()->with('error', 'Sản phẩm này đã ngưng kinh doanh.');
        }

        // Kiểm tra nếu sản phẩm có biến thể mà chưa chọn biến thể
        $hasVariants = ProductVariant::where('product_id', $product->id)->exists();

        if ($hasVariants && !$variantId) {
            return redirect()->back()->with('error', 'Vui lòng chọn biến thể sản phẩm trước khi thêm vào giỏ hàng.');
        }

        // Nếu có variant, dùng giá của variant và kiểm tra tồn kho variant
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);

            // ✅ KIỂM TRA TRẠNG THÁI VARIANT (nếu có)
            if (isset($variant->status) && ($variant->status == 0 || $variant->status == 'inactive')) {
                return redirect()->back()->with('error', 'Biến thể sản phẩm này đã ngưng kinh doanh.');
            }

            // ✅ KIỂM TRA TỒN KHO VARIANT
            if ($variant->stock_quantity < $quantity) { // Điều chỉnh tên cột theo DB của bạn
                return redirect()->back()->with('error', "Chỉ còn {$variant->stock_quantity} sản phẩm trong kho.");
            }

            $price = $variant->variant_price;
            $availableStock = $variant->stock_quantity;
        } else {
            // ✅ KIỂM TRA TỒN KHO SẢN PHẨM CHÍNH
            if ($product->stock_quantity < $quantity) { // Điều chỉnh tên cột theo DB của bạn
                return redirect()->back()->with('error', "Chỉ còn {$product->stock_quantity} sản phẩm trong kho.");
            }

            $price = $product->price;
            $availableStock = $product->stock_quantity;
        }

        // ✅ KIỂM TRA HẾT HÀNG
        if ($availableStock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm này hiện đã hết hàng.');
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
            // ✅ KIỂM TRA TỔNG SỐ LƯỢNG SAU KHI CỘNG
            $newQuantity = $item->quantity + $quantity;
            if ($newQuantity > $availableStock) {
                return redirect()->back()->with('error', "Không thể thêm {$quantity} sản phẩm. Bạn đã có {$item->quantity} trong giỏ hàng, chỉ còn {$availableStock} sản phẩm trong kho.");
            }

            $item->quantity = $newQuantity;
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

        // ✅ XÓA KHỎI DANH SÁCH YÊU THÍCH nếu đến từ wishlist
        if ($request->has('from_wishlist')) {
            Wishlist::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->delete();
        }

        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
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

    public function buyNow(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để mua hàng.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
            'variant_id' => 'nullable|exists:product_variants,id',
        ]);

        $user = auth()->user();
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        $product = Product::findOrFail($productId);

        // Nếu sản phẩm có biến thể mà chưa chọn => báo lỗi
        if ($product->product_type === 'variable' && !$variantId) {
            return back()->with('error', 'Vui lòng chọn biến thể sản phẩm để mua ngay.');
        }


        // Kiểm tra kho
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            if ($variant->stock_quantity < $quantity) {
                return back()->with('error', 'Sản phẩm không đủ số lượng tồn kho.');
            }
        } else {
            if ($product->quantity < $quantity) {
                return back()->with('error', 'Sản phẩm không đủ số lượng tồn kho.');
            }
        }

        $price = $variantId
            ? ProductVariant::findOrFail($variantId)->variant_price
            : $product->price;

        // Clear giỏ hàng cũ (nếu bạn muốn giữ đơn giản)
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->delete();

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $productId,
            'product_variant_id' => $variantId,
            'quantity' => $quantity,
            'price' => $price,
        ]);

        return redirect()->route('checkout')->with('success', 'Đang chuyển tới trang thanh toán...');
    }


}