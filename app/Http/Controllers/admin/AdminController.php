<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Parse date range từ request
        $dateRange = $request->input('date_range');
        $fromDate = null;
        $toDate = null;
    
        if ($dateRange) {
            // Hỗ trợ cả ' to ' và ' – ' làm dấu tách ngày
            if (str_contains($dateRange, ' to ')) {
                [$from, $to] = explode(' to ', $dateRange);
            } elseif (str_contains($dateRange, '–')) {
                [$from, $to] = explode('–', $dateRange);
            } else {
                $from = $to = $dateRange; // chọn 1 ngày duy nhất
            }
    
            try {
                $fromDate = Carbon::createFromFormat('d M, Y', trim($from))->startOfDay();
                $toDate = Carbon::createFromFormat('d M, Y', trim($to))->endOfDay();
            } catch (\Exception $e) {
                // fallback nếu format sai
                $fromDate = $toDate = now();
            }
        }
    
        // Helper closure để áp dụng whereBetween nếu có date filter
        $filterByDate = function ($query) use ($fromDate, $toDate) {
            if ($fromDate && $toDate) {
                return $query->whereBetween('created_at', [$fromDate, $toDate]);
            }
            return $query->whereDate('created_at', today());
        };
    
        // Doanh thu & đơn hàng
        $revenueToday = Order::when(true, $filterByDate)->sum('final_amount');
        $ordersToday = Order::when(true, $filterByDate)->count();
    
        // Người dùng mới
        $usersToday = User::when(true, $filterByDate)->count();
    
        // Tổng số sản phẩm (tất cả)
        $productsCount = Product::count();
    
        // Tổng doanh thu toàn thời gian
        $totalEarnings = Order::sum('final_amount');
    
        // Đơn hàng mới nhất
        $latestOrders = Order::with('user')->latest()->take(5)->get();
    
        // Danh mục bán chạy nhất
        $topCategories = Categories::withCount([
            'products as total_sales' => function ($query) use ($fromDate, $toDate) {
                $query->whereHas('orderItems', function ($subQuery) use ($fromDate, $toDate) {
                    $subQuery->when($fromDate && $toDate, function ($q) use ($fromDate, $toDate) {
                        return $q->whereBetween('order_items.created_at', [$fromDate, $toDate]);
                    }, function ($q) {
                        return $q->whereDate('order_items.created_at', today());
                    });
                });
            }
        ])
        ->orderByDesc('total_sales')
        ->take(5)
        ->get();
    
        $categoryLabels = $topCategories->pluck('name')->toArray();
        $categoryValues = $topCategories->pluck('total_sales')->toArray();
    
        // Sản phẩm bán chạy nhất
        $topProducts = DB::table('products')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('order_items.created_at', [$fromDate, $toDate]);
            }, function ($query) {
                return $query->whereDate('order_items.created_at', today());
            })
            ->select(
                'products.id',
                'products.name',
                DB::raw('IFNULL(product_variants.variant_price, products.price) as price'),
                'products.created_at',
                DB::raw('SUM(order_items.quantity) as total_orders'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_amount')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.created_at',
                'product_variants.variant_price'
            )
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();
    
        // Đơn hàng gần nhất kèm sản phẩm
        $recentOrders = Order::with(['user', 'orderItems.product'])
        ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }, function ($query) {
            $query->whereDate('created_at', today()); // Lọc theo ngày hiện tại nếu không có khoảng thời gian
        })
        ->latest()
        ->take(5)
        ->get();
    
        // Doanh thu 7 ngày hoặc theo khoảng thời gian
        $revenueByDay = Order::selectRaw('DATE(created_at) as day, SUM(final_amount) as total')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }, function ($query) {
                $query->whereBetween('created_at', [now()->subDays(6), now()]);
            })
            ->groupBy('day')
            ->orderBy('day')
            ->get();
    
        $revenueLabels = $revenueByDay->pluck('day')->map(fn($d) => Carbon::parse($d)->format('d/m'))->toArray();
        $revenueValues = $revenueByDay->pluck('total')->toArray();
    
        // Thống kê chung
        $totalOrdersAll = Order::count();
        $totalEarningsAll = Order::sum('final_amount');
        $refundsCount = Order::where('status', 'refunded')->count();
        $conversationRatio = $totalOrdersAll
            ? round(Order::where('status', 'completed')->count() / $totalOrdersAll * 100, 2)
            : 0;
    
        return view('admin.pages.dashboards', compact(
            'user',
            'dateRange',
            'revenueToday',
            'ordersToday',
            'productsCount',
            'usersToday',
            'totalEarnings',
            'latestOrders',
            'topProducts',
            'revenueLabels',
            'revenueValues',
            'totalOrdersAll',
            'totalEarningsAll',
            'refundsCount',
            'conversationRatio',
            'categoryLabels',
            'categoryValues',
            'topCategories',
            'recentOrders'
        ));
    }
    
    

    // public function dashboard(Request $request)
    // {
    //     $user = Auth::user();
    
    //     // Parse date range từ request
    //     $dateRange = $request->input('date_range');
    //     $fromDate = null;
    //     $toDate = null;
    
    //     if ($dateRange && str_contains($dateRange, 'to')) {
    //         [$from, $to] = explode(' to ', $dateRange);
    //         $fromDate = Carbon::createFromFormat('d M, Y', trim($from))->startOfDay();
    //         $toDate = Carbon::createFromFormat('d M, Y', trim($to))->endOfDay();
    //     }
    
    //     // Helper closure để áp dụng whereBetween nếu có date filter
    //     $filterByDate = function ($query) use ($fromDate, $toDate) {
    //         return $fromDate && $toDate
    //             ? $query->whereBetween('created_at', [$fromDate, $toDate])
    //             : $query->whereDate('created_at', today());
    //     };
    
    //     // Doanh thu & đơn hàng
    //     $revenueToday = Order::when(true, $filterByDate)->sum('final_amount');
    //     $ordersToday = Order::when(true, $filterByDate)->count();
    
    //     // Người dùng mới
    //     $usersToday = User::when(true, $filterByDate)->count();
    
    //     // Tổng số sản phẩm (tất cả)
    //     $productsCount = Product::count();
    
    //     // Tổng doanh thu toàn thời gian
    //     $totalEarnings = Order::sum('final_amount');
    
    //     // Đơn hàng mới nhất
    //     $latestOrders = Order::with('user')->latest()->take(5)->get();
    
    //     // Danh mục bán chạy nhất
    //     $topCategories = Categories::withCount([
    //         'products as total_sales' => function ($query) use ($fromDate, $toDate) {
    //             $query->whereHas('orderItems', function ($subQuery) use ($fromDate, $toDate) {
    //                 if ($fromDate && $toDate) {
    //                     $subQuery->whereBetween('order_items.created_at', [$fromDate, $toDate]);
    //                 } else {
    //                     $subQuery->whereDate('order_items.created_at', today());
    //                 }
    //             });
    //         }
    //     ])
    //     ->orderByDesc('total_sales')
    //     ->take(5)
    //     ->get();
    
    //     $categoryLabels = $topCategories->pluck('name')->toArray();
    //     $categoryValues = $topCategories->pluck('total_sales')->toArray();
    
    //     // Sản phẩm bán chạy nhất
    //     $topProducts = DB::table('products')
    //         ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
    //         ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
    //         ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
    //             $query->whereBetween('order_items.created_at', [$fromDate, $toDate]);
    //         }, function ($query) {
    //             $query->whereDate('order_items.created_at', today());
    //         })
    //         ->select(
    //             'products.id',
    //             'products.name',
    //             DB::raw('IFNULL(product_variants.variant_price, products.price) as price'),
    //             'products.created_at',
    //             DB::raw('SUM(order_items.quantity) as total_orders'),
    //             DB::raw('SUM(order_items.price * order_items.quantity) as total_amount')
    //         )
    //         ->groupBy(
    //             'products.id',
    //             'products.name',
    //             'products.price',
    //             'products.created_at',
    //             'product_variants.variant_price'
    //         )
    //         ->orderByDesc('total_orders')
    //         ->limit(5)
    //         ->get();
    
    //     // Đơn hàng gần nhất kèm sản phẩm
    //     $recentOrders = Order::with(['user', 'orderItems.product'])
    //         ->latest()
    //         ->take(5)
    //         ->get();
    
    //     // Doanh thu 7 ngày hoặc theo khoảng thời gian
    //     $revenueByDay = Order::selectRaw('DATE(created_at) as day, SUM(final_amount) as total')
    //         ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
    //             $query->whereBetween('created_at', [$fromDate, $toDate]);
    //         }, function ($query) {
    //             $query->whereBetween('created_at', [now()->subDays(6), now()]);
    //         })
    //         ->groupBy('day')
    //         ->orderBy('day')
    //         ->get();
    
    //     $revenueLabels = $revenueByDay->pluck('day')->map(fn($d) => Carbon::parse($d)->format('d/m'))->toArray();
    //     $revenueValues = $revenueByDay->pluck('total')->toArray();
    
    //     // Thống kê chung
    //     $totalOrdersAll = Order::count();
    //     $totalEarningsAll = Order::sum('final_amount');
    //     $refundsCount = Order::where('status', 'refunded')->count();
    //     $conversationRatio = $totalOrdersAll
    //         ? round(Order::where('status', 'completed')->count() / $totalOrdersAll * 100, 2)
    //         : 0;
    
    //     return view('admin.pages.dashboards', compact(
    //         'user',
    //         'dateRange',
    //         'revenueToday',
    //         'ordersToday',
    //         'productsCount',
    //         'usersToday',
    //         'totalEarnings',
    //         'latestOrders',
    //         'topProducts',
    //         'revenueLabels',
    //         'revenueValues',
    //         'totalOrdersAll',
    //         'totalEarningsAll',
    //         'refundsCount',
    //         'conversationRatio',
    //         'categoryLabels',
    //         'categoryValues',
    //         'topCategories',
    //         'recentOrders'
    //     ));
    // }
    


    public function getRevenueData(Request $request)
    {
        $range = $request->input('date_range', 'year');

        $from = match ($range) {
            'today' => now()->startOfDay(),
            'yesterday' => now()->subDay()->startOfDay(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfWeek(),
        };

        $to = match ($range) {
            'today', 'yesterday' => now()->endOfDay(),
            'month' => now()->endOfMonth(),
            'year' => now()->endOfYear(),
            default => now()->endOfWeek(),
        };

        $data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(final_amount) as revenue')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))->toArray(),
            'orders' => $data->pluck('orders')->toArray(),
            'revenues' => $data->pluck('revenue')->toArray(),
        ]);
    }
}
