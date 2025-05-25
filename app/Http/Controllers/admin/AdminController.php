<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
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

        // Tổng người dùng 
        $totalUsers = User::count();
    
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
        ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id') // Join thêm bảng orders
        ->whereIn('orders.status', ['delivered', 'completed']) // Lọc trạng thái đơn
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

        // Tỷ lệ đơn hàng thành công
        $completedOrders = $filteredOrders->where('status', 'completed')->count();
        $successRate = $totalOrdersAll > 0
            ? round(($completedOrders / $totalOrdersAll) * 100, 2)
            : 0;
        
       $totalReviews = Review::whereBetween('created_at', [$fromDate, $toDate])->count();


        // Tính tỉ lệ chuyển đổi đơn hàng
        $usersWithOrders = Order::whereBetween('created_at', [$fromDate, $toDate])
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->unique()
            ->count();
        
        $conversionRate = $usersToday > 0
            ? round(($usersWithOrders / $usersToday) * 100, 2)
            : 0;

        // khách hàng mới   
       $newCustomers = User::whereBetween('created_at', [$fromDate, $toDate])
        ->whereHas('roles', function ($query) {
            $query->where('role_id', 4);
        })->count();


                
        // Lấy sản phẩm đơn còn hàng
        $simpleInStock = Product::where('product_type', 'simple')
            ->where('quantity', '>', 0)
            ->count();

        // Lấy sản phẩm đơn hết hàng
        $simpleOutOfStock = Product::where('product_type', 'simple')
            ->where(function ($query) {
                $query->where('quantity', '<=', 0)
                    ->orWhereNull('quantity');
            })
            ->count();

        // Lấy danh sách ID sản phẩm có biến thể
        $variantProducts = Product::where('product_type', 'variant')->pluck('id');

        // Đếm sản phẩm có biến thể còn hàng
        $variantInStock = Product::whereIn('id', function ($query) {
                $query->select('product_id')
                    ->from('product_variants')
                    ->groupBy('product_id')
                    ->havingRaw('SUM(stock_quantity) > 0');
            })
            ->count();

        // Đếm sản phẩm có biến thể hết hàng
        $variantOutOfStock = Product::whereIn('id', function ($query) {
                $query->select('product_id')
                    ->from('product_variants')
                    ->groupBy('product_id')
                    ->havingRaw('SUM(stock_quantity) <= 0');
            })
            ->count();

        // Tổng hợp lại
        $inStockCount = $simpleInStock + $variantInStock;
        $outOfStockCount = $simpleOutOfStock + $variantOutOfStock;





    
    
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
            'successRate',
            'conversionRate',
            'totalUsers',
            'newCustomers',
            'inStockCount',
            'outOfStockCount',
            'totalReviews'

        ));
    }
    
    

}
