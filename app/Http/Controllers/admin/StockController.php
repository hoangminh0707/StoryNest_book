<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {

        // Lấy ngày bắt đầu và kết thúc từ request, mặc định là tháng này
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->toDateString());

        $startOfPeriod = Carbon::parse($startDate)->startOfDay();
        $endOfPeriod = Carbon::parse($endDate)->endOfDay();

        // Khởi tạo query cơ bản
        $query = Product::with(['images'])
            ->withSum('variants', 'stock_quantity')
            ->with(['variants' => function ($variantQuery) use ($startOfPeriod, $endOfPeriod) {
                $variantQuery->with(['orderItems' => function ($orderItemQuery) use ($startOfPeriod, $endOfPeriod) {
                    $orderItemQuery->whereBetween('created_at', [$startOfPeriod, $endOfPeriod]);
                }]);
            }]);

        // Tìm kiếm theo tên sản phẩm hoặc tên biến thể
        if ($request->filled('search')) {
            $query->where('products.name', 'like', '%' . $request->search . '%');
        }


        // Lọc theo trạng thái tồn kho
        if ($request->filled('stock_status')) {
            $status = $request->stock_status;

            if ($status === 'out_of_stock') {
                $query->having('variants_sum_stock_quantity', '<=', 0);
            } elseif ($status === 'low_stock') {
                $query->having('variants_sum_stock_quantity', '>', 0)
                    ->having('variants_sum_stock_quantity', '<=', 10);
            } elseif ($status === 'in_stock') {
                $query->having('variants_sum_stock_quantity', '>', 10);
            }
        }

        // Phân trang kết quả
        $products = $query->paginate(15);

        // Tính tổng số lượng đã bán trong khoảng thời gian
        $products->getCollection()->transform(function ($product) use ($startOfPeriod, $endOfPeriod) {
            $totalSold = 0;

            if ($product->product_type === 'simple') {
                // Nếu là sản phẩm đơn
                $totalSold = $product->orderItems()
                    ->whereBetween('created_at', [$startOfPeriod, $endOfPeriod])
                    ->sum('quantity');
            } else {
                // Với sản phẩm có biến thể
                foreach ($product->variants as $variant) {
                    $sold = $variant->orderItems->sum('quantity');
                    $totalSold += $sold;
                }
            }

            $product->sold_this_period = $totalSold;
            return $product;
        });

        return view('admin.pages.stocks.index', compact('products', 'startDate', 'endDate'));
    }

    // Hiển thị form cập nhật tồn kho cho sản phẩm
    public function showUpdateStockForm($productId)
    {
        // Lấy sản phẩm cùng với các biến thể và thuộc tính của chúng
        $product = Product::with(['variants.attributeValues.attribute'])->findOrFail($productId);

        // Truyền sản phẩm vào view
        return view('admin.pages.stocks.update', compact('product'));
    }

    // Cập nhật tồn kho cho sản phẩm và biến thể
    public function updateStock(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'variant_id' => 'nullable|exists:product_variants,id',
            'note' => 'nullable|string',  // Thêm trường ghi chú nếu có
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.numeric' => 'Số lượng phải là một số.',
        ]);

        // Kiểm tra nếu số lượng nhập vào là 0
        if ($validated['quantity'] == 0) {
            return redirect()->back()
                ->withErrors(['quantity' => 'Số lượng không được bằng 0.'])
                ->withInput();
        }

        // Lấy sản phẩm từ database
        $product = Product::findOrFail($request->product_id);

        // Lưu lại tồn kho cũ để ghi vào lịch sử
        $old_quantity = $product->quantity;

        // Kiểm tra nếu là sản phẩm đơn (không có variant_id)
        if (!$request->has('variant_id')) {
            // Nếu số lượng âm và vượt quá số lượng tồn kho hiện tại của sản phẩm đơn
            if ($request->quantity < 0 && abs($request->quantity) > $product->quantity) {
                return redirect()->back()
                    ->withErrors(['quantity' => 'Số lượng nhập vào vượt quá tồn kho sản phẩm đơn!'])
                    ->withInput();
            }

            // Cập nhật tồn kho cho sản phẩm đơn
            $product->quantity += $request->quantity;
            $product->save();

            // Lưu lịch sử thay đổi vào bảng stock_logs
            StockLog::create([
                'product_id' => $product->id,
                'variant_id' => null, // Không có variant đối với sản phẩm đơn
                'admin_id' => auth()->id(), // ID của admin thực hiện thao tác
                'change_quantity' => $request->quantity,
                'note' => $request->note, // Ghi chú (nếu có)
            ]);
        } else {
            // Cập nhật tồn kho cho biến thể
            $variant = $product->variants()->findOrFail($request->variant_id);

            // Lưu lại tồn kho cũ của biến thể
            $old_variant_quantity = $variant->stock_quantity;

            // Nếu số lượng âm và vượt quá số lượng tồn kho hiện tại của biến thể
            if ($request->quantity < 0 && abs($request->quantity) > $variant->stock_quantity) {
                return redirect()->back()
                    ->withErrors(['quantity' => 'Số lượng nhập vào vượt quá tồn kho biến thể hiện tại!'])
                    ->withInput();
            }

            // Cập nhật tồn kho cho biến thể
            $variant->stock_quantity += $request->quantity;
            $variant->save();

            // Lưu lịch sử thay đổi vào bảng stock_logs
            StockLog::create([
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'admin_id' => auth()->id(), // ID của admin thực hiện thao tác
                'change_quantity' => $request->quantity,
                'note' => $request->note, // Ghi chú (nếu có)
            ]);
        }

        // Thêm thông báo thành công vào session và chuyển hướng về trang danh sách tồn kho
        return redirect()->route('admin.stocks.index')->with('success', 'Cập nhật tồn kho thành công!');
    }
    public function showHistory($productId)
    {
        $product = Product::findOrFail($productId);
    
        // Lấy toàn bộ log để tính toán tồn kho
        $allLogs = StockLog::with([
            'product',
            'variant.attributeValues.attribute', 
            'admin'
        ])
        ->where('product_id', $productId)
        ->orderBy('created_at', 'asc') // quan trọng để tính đúng
        ->get();
    
        // Tính toán stock_before và stock_after tạm thời
        $stock = 0;
        foreach ($allLogs as $log) {
            $log->stock_before = $stock;
            $stock += $log->change_quantity;
            $log->stock_after = $stock;
        }
    
        // Sắp xếp lại theo thời gian mới nhất để hiển thị
        $allLogs = $allLogs->sortByDesc('created_at')->values();
    
        // Phân trang thủ công
        $page = request()->get('page', 1);
        $perPage = 15;
        $pagedLogs = $allLogs->forPage($page, $perPage);
        $stockLogs = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedLogs,
            $allLogs->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    
        return view('admin.pages.stocks.history', compact('product', 'stockLogs'));
    }
    
    
}
