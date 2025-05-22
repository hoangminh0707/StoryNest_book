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
            'note' => 'nullable|string',
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.numeric' => 'Số lượng phải là một số.',
        ]);

        if ($validated['quantity'] == 0) {
            return redirect()->back()
                ->withErrors(['quantity' => 'Số lượng không được bằng 0.'])
                ->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        // Nếu là sản phẩm đơn
        if (!$request->has('variant_id')) {
            if ($request->quantity < 0 && abs($request->quantity) > $product->quantity) {
                return redirect()->back()
                    ->withErrors(['quantity' => 'Số lượng nhập vào vượt quá tồn kho sản phẩm đơn!'])
                    ->withInput();
            }

            // Cập nhật tồn kho
            $product->quantity += $request->quantity;
            $product->save();

            // Ghi log
            StockLog::create([
                'product_id' => $product->id,
                'variant_id' => null,
                'admin_id' => auth()->id(),
                'change_quantity' => $request->quantity,
                'stock_after_change' => $product->quantity,
                'note' => $request->note,
            ]);
        } else {
            $variant = $product->variants()->findOrFail($request->variant_id);

            if ($request->quantity < 0 && abs($request->quantity) > $variant->stock_quantity) {
                return redirect()->back()
                    ->withErrors(['quantity' => 'Số lượng nhập vào vượt quá tồn kho biến thể hiện tại!'])
                    ->withInput();
            }

            // Cập nhật tồn kho
            $variant->stock_quantity += $request->quantity;
            $variant->save();

            // Ghi log
            StockLog::create([
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'admin_id' => auth()->id(),
                'change_quantity' => $request->quantity,
                'stock_after_change' => $variant->stock_quantity,
                'note' => $request->note,
            ]);
        }

        return redirect()->route('admin.stocks.index')->with('success', 'Cập nhật tồn kho thành công!');
    }

   public function showHistory($productId)
    {
        $product = Product::findOrFail($productId);

        $allLogs = StockLog::with([
            'product',
            'variant.attributeValues.attribute',
            'admin'
        ])
        ->where('product_id', $productId)
        ->orderBy('created_at', 'asc') // để tính stock_before đúng
        ->get();

        // Tính stock_before từ stock_after
        $previous = 0;
        foreach ($allLogs as $log) {
            $log->stock_before = $previous;
            $previous = $log->stock_after_change ?? ($previous + $log->change_quantity);
        }

        // Sắp xếp lại theo thời gian mới nhất
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
