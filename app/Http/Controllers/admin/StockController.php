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
            ->with([
                'variants' => function ($variantQuery) use ($startOfPeriod, $endOfPeriod) {
                    $variantQuery->with([
                        'orderItems' => function ($orderItemQuery) use ($startOfPeriod, $endOfPeriod) {
                            $orderItemQuery->whereBetween('created_at', [$startOfPeriod, $endOfPeriod]);
                        }
                    ]);
                }
            ]);

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

    public function updateStock(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|not_in:0',
            'variant_id' => 'nullable|exists:product_variants,id',
            'note' => 'nullable|string',
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.numeric' => 'Số lượng phải là một số.',
            'quantity.not_in' => 'Số lượng không được bằng 0.',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $change = $validated['quantity'];

        if (!$validated['variant_id']) {
            // Sản phẩm đơn
            $stockBefore = $product->quantity ?? 0;

            if ($change < 0 && abs($change) > $stockBefore) {
                return back()->withErrors(['quantity' => 'Số lượng vượt quá tồn kho hiện tại'])->withInput();
            }

            $product->quantity = $stockBefore + $change;
            $product->save();

            StockLog::create([
                'product_id' => $product->id,
                'variant_id' => null,
                'admin_id' => auth()->id(),
                'change_quantity' => $change,
                'note' => $validated['note'],
                'stock_before' => $stockBefore,
                'stock_after' => $product->quantity,
            ]);
        } else {
            // Sản phẩm có biến thể
            $variant = ProductVariant::where('product_id', $product->id)
                ->findOrFail($validated['variant_id']);

            $stockBefore = $variant->stock_quantity;

            if ($change < 0 && abs($change) > $stockBefore) {
                return back()->withErrors(['quantity' => 'Số lượng vượt quá tồn kho biến thể'])->withInput();
            }

            // Cập nhật tồn kho
            $variant->stock_quantity += $change;
            $variant->save();

            $stockAfter = $variant->stock_quantity;

            StockLog::create([
                'product_id' => $product->id,
                'variant_id' => $variant->id,
                'admin_id' => auth()->id(),
                'change_quantity' => $change,
                'note' => $validated['note'],
                'stock_before' => $stockBefore,          // chính xác
                'stock_after' => $stockAfter,           // chính xác
            ]);
        }

        return redirect()->route('admin.stocks.index')->with('success', 'Cập nhật tồn kho thành công!');
    }


    public function showHistory($productId)
    {
        $product = Product::findOrFail($productId);

        // Lấy lịch sử thay đổi tồn kho, kèm các quan hệ cần thiết
        $stockLogs = StockLog::with([
            'product.thumbnail',                        // Ảnh thumbnail của sản phẩm
            'variant.attributeValues.attribute',        // Thông tin thuộc tính của biến thể (nếu có)
            'admin'                                     // Thông tin người cập nhật
        ])
            ->where('product_id', $productId)
            ->orderByDesc('created_at')                 // Sắp xếp mới nhất lên đầu
            ->paginate(15);

        return view('admin.pages.stocks.history', compact('product', 'stockLogs'));
    }



}