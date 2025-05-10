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
        Paginator::useBootstrapFive();



        View::composer('*', function ($view) {
            // Dữ liệu mặc định
            $statusLabels = [
                'pending' => 'Chờ xử lý',
                'confirmed' => 'Đã xác nhận',
                'shipped' => 'Đang giao',
                'delivered' => 'Đã giao',
                'completed' => 'Đã hoàn thành',
                'cancelled' => 'Đã hủy',
            ];

            $statusColors = [
                'pending' => 'warning',
                'confirmed' => 'primary',
                'shipped' => 'info',
                'delivered' => 'success',
                'completed' => 'success',
                'cancelled' => 'secondary',
            ];

            $wishlistItems = collect();
            $cartItems = collect();

            if (auth()->check()) {
                $wishlistItems = Wishlist::with('product')->where('user_id', auth()->id())->get();

                $cart = Cart::with('items.product', 'items.variant.attributeValues')
                    ->where('user_id', auth()->id())
                    ->first();

                $cartItems = $cart?->items ?? collect();
            }

            $danhMucSachs = Categories::with('childrenRecursive')
                ->where('name', 'Sách')
                ->first();

            $danhMucDungCu = Categories::with('childrenRecursive')
                ->where('name', 'VPP-Dụng cụ học sinh')
                ->first();

            $danhMucDoChoi = Categories::with('childrenRecursive')
                ->where('name', 'Đồ chơi')
                ->first();

            $danhMucHanhTrang = Categories::with('childrenRecursive')
                ->where('name', 'Hành trang đến trường')
                ->first();

            $view->with([
                'statusLabels' => $statusLabels,
                'statusColors' => $statusColors,
                'wishlistItems' => $wishlistItems,
                'cartItems' => $cartItems,
                'danhMucSachs' => $danhMucSachs,
                'danhMucDungCu' => $danhMucDungCu,
                'danhMucDoChoi' => $danhMucDoChoi,
                'danhMucHanhTrang' => $danhMucHanhTrang,
            ]);
        });

    }
}