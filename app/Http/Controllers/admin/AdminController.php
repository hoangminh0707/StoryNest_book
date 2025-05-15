<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Refund;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
    
        // Parse bộ lọc ngày duy nhất
        $dateRange = $request->input('date_range');
        $fromDate = $toDate = null;
    
        if ($dateRange) {
            // Chấp nhận cả dấu 'to', '–' hoặc chỉ 1 ngày
            if (str_contains($dateRange, ' to ')) {
                [$from, $to] = explode(' to ', $dateRange);
            } elseif (str_contains($dateRange, '–')) {
                [$from, $to] = explode('–', $dateRange);
            } else {
                $from = $to = $dateRange;
            }
    
            try {
                $fromDate = Carbon::createFromFormat('d M, Y', trim($from))->startOfDay();
                $toDate = Carbon::createFromFormat('d M, Y', trim($to))->endOfDay();
            } catch (\Exception $e) {
                $fromDate = now()->startOfDay();
                $toDate = now()->endOfDay();
            }
        } else {
            $fromDate = now()->startOfDay();
            $toDate = now()->endOfDay();
        }
    
        // Doanh thu & đơn hàng
        $revenueToday = Order::whereBetween('created_at', [$fromDate, $toDate])->sum('final_amount');
        $ordersToday = Order::whereBetween('created_at', [$fromDate, $toDate])->count();
    
        // Người dùng mới
        $usersToday = User::whereBetween('created_at', [$fromDate, $toDate])->count();
    
        // Tổng số sản phẩm
        $productsCount = Product::count();
    
        // Tổng doanh thu toàn thời gian
        $totalEarnings = Order::sum('final_amount');
    
        // Đơn hàng mới nhất
        $latestOrders = Order::with('user')->orderByDesc('created_at')->take(5)->get();
    
        // Sản phẩm bán chạy nhất
        $topProducts = DB::table('products')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->whereBetween('order_items.created_at', [$fromDate, $toDate])
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
                'products.created_at',
                'product_variants.variant_price',
                'products.price'
            )
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();
    
        // Đơn hàng gần nhất kèm sản phẩm
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->latest()
            ->take(5)
            ->get();
    
        // Biểu đồ đơn hàng & doanh thu
        $filteredOrders = Order::whereBetween('created_at', [$fromDate, $toDate])->get();

        $totalOrdersAll = $filteredOrders->count();
        $totalRevenue = $filteredOrders->sum('final_amount');

        // Gom theo ngày (Y-m-d) để dễ sắp xếp
        $groupedByDate = $filteredOrders->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d'); // Dùng định dạng này để sắp đúng
        });

        // Sắp xếp theo key ngày tăng dần
        $sortedByDate = $groupedByDate->sortKeys();

        // Tạo nhãn và dữ liệu
        $revenueLabels = $sortedByDate->keys()->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M'));
        $revenueValues = $sortedByDate->map(fn($orders) => $orders->sum('final_amount'))->values();
        $orderCounts = $sortedByDate->map(fn($orders) => $orders->count())->values();
                                                                                                                                                                
        // Trạng thái đơn hàng
        $statusGroups = $filteredOrders->groupBy('status');
        $statusChartLabels = $statusGroups->keys();
        $statusChartValues = $statusGroups->map(fn($orders) => $orders->count())->values();
    
    
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
            'recentOrders',
            'totalOrdersAll',
            'totalRevenue',
            'revenueLabels',
            'revenueValues',
            'orderCounts',
            'statusChartLabels',
            'statusChartValues',
        ));
    }
    
    

}
