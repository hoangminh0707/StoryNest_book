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

        // Lấy giá trị lọc ngày từ request (dạng: "01 Jan, 2024 to 15 Jan, 2024")
        $dateRange = $request->input('date_range');
        $fromDate = null;
        $toDate = null;

        if ($dateRange && str_contains($dateRange, 'to')) {
            [$from, $to] = explode(' to ', $dateRange);
            $fromDate = Carbon::createFromFormat('d M, Y', trim($from))->startOfDay();
            $toDate = Carbon::createFromFormat('d M, Y', trim($to))->endOfDay();
        }

        // Doanh thu trong khoảng hoặc hôm nay
        $revenueToday = Order::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        }, function ($query) {
            return $query->whereDate('created_at', today());
        })
            ->sum('final_amount');

        // Đơn hàng trong khoảng hoặc hôm nay
        $ordersToday = Order::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        }, function ($query) {
            return $query->whereDate('created_at', today());
        })
            ->count();

        // Thống kê tổng
        $productsCount = Product::count();
        $usersToday = User::when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
            return $query->whereBetween('created_at', [$fromDate, $toDate]);
        }, function ($query) {
            return $query->whereDate('created_at', today());
        })
            ->count();

        // Tổng doanh thu chưa phân trang hoặc lọc
        $totalEarnings = Order::sum('final_amount');

        // Các đơn hàng mới nhất
        $latestOrders = Order::with('user')->latest()->take(5)->get();



        $topCategories = Categories::withCount([
            'products as total_sales' => function ($productQuery) use ($fromDate, $toDate) {
                $productQuery->whereHas('orderItems', function ($orderItemQuery) use ($fromDate, $toDate) {
                    if ($fromDate && $toDate) {
                        $orderItemQuery->whereBetween('order_items.created_at', [$fromDate, $toDate]);
                    }
                });
            }
        ])
        ->orderByDesc('total_sales') // Sắp xếp theo tổng sản phẩm có đơn hàng
        ->take(5) // Lấy 5 danh mục có tổng bán cao nhất
        ->get();
        
        $categoryLabels = $topCategories->pluck('name')->toArray();
        $categoryValues = $topCategories->pluck('total_sales')->toArray();
        


        // Best-Selling Products: top 5 theo tổng số lượng bán
        $topProducts = DB::table('products')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                'products.created_at',
                DB::raw('SUM(order_items.quantity) as total_orders'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_amount')
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.price',
                'products.created_at'
            )
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();

        // Recent Orders: lấy 5 đơn mới nhất, kèm user và orderItems->product->vendor
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->take(5)
            ->get();


        // Biểu đồ doanh thu 7 ngày
        $revenueByDay = Order::selectRaw('DATE(created_at) as day, SUM(final_amount) as total')
            ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
                return $query->whereBetween('created_at', [$fromDate, $toDate]);
            }, function ($query) {
                return $query->whereBetween('created_at', [now()->subDays(6), now()]);
            })
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $revenueLabels = $revenueByDay->pluck('day')
            ->map(fn($d) => Carbon::parse($d)->format('d/m'))
            ->toArray();
        $revenueValues = $revenueByDay->pluck('total')->toArray();

        // Thống kê thêm cho card summary
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
