<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Categories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (auth()->check()) {
                // Lấy danh sách yêu thích
                $wishlistItems = Wishlist::with('product')->where('user_id', auth()->id())->get();

                // Lấy giỏ hàng và sản phẩm + biến thể sản phẩm
                $cart = Cart::with('items.product', 'items.variant.attributeValues')->where('user_id', auth()->id())->first();

                $cartItems = $cart?->items ?? collect();



                // Truyền cả hai vào view
                $view->with('wishlistItems', $wishlistItems);
                $view->with('cartItems', $cartItems);
            } else {
                $view->with('wishlistItems', collect());
                $view->with('cartItems', collect());
            }

            Paginator::useBootstrapFive();
        });

        View::composer('*', function ($view) {
            $danhMucSachs = Categories::with('childrenRecursive')
                ->where('name', 'Sách')
                ->first();

            $danhMucDungCu = Categories::with('childrenRecursive')
                ->where('name', 'Dụng cụ học sinh')
                ->first();

            $danhMucDoChoi = Categories::with('childrenRecursive')
                ->where('name', 'Đồ chơi')
                ->first();

            $danhMucHanhTrang = Categories::with('childrenRecursive')
                ->where('name', 'Hành trang đến trường')
                ->first();

            $view->with([
                'danhMucSachs' => $danhMucSachs,
                'danhMucDungCu' => $danhMucDungCu,
                'danhMucDoChoi' => $danhMucDoChoi,
                'danhMucHanhTrang' => $danhMucHanhTrang,
            ]);
        });
    }
}
