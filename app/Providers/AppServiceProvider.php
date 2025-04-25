<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Wishlist;
use App\Models\Cart;

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

                // Lấy giỏ hàng và sản phẩm tương ứng
                $cart = Cart::with('items.product')->where('user_id', auth()->id())->first();
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
    }

}
