<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockLog;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
class StockController extends Controller
{


    public function index(Request $request)
    {
        $query = Product::with(['images', 'variants.orderItems', 'orderItems']);

        if ($request->filled('search')) {
            $query->where('products.name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        // Lọc tồn kho thủ công trên collection
        if ($request->filled('stock_status')) {
            $status = $request->stock_status;

            $products = $products->filter(function ($product) use ($status) {
                if ($product->product_type === 'simple') {
                    $qty = $product->quantity ?? 0;
                    if ($status === 'out_of_stock') {
                        return $qty <= 0;
                    } elseif ($status === 'low_stock') {
                        return $qty > 0 && $qty <= 10;
                    } elseif ($status === 'in_stock') {
                        return $qty > 10;
                    }
                } else {
                    // Tính tổng tồn kho biến thể
                    $totalStock = $product->variants->sum('stock_quantity');

                    if ($status === 'out_of_stock') {
                        return $totalStock <= 0;
                    } elseif ($status === 'low_stock') {
                        return $totalStock > 0 && $totalStock <= 10;
                    } elseif ($status === 'in_stock') {
                        return $totalStock > 10;
                    }
                }
                return false;
            });
        }

        // Chuyển collection về paginate thủ công
        $perPage = 15;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $products->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginatedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $products->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

     // Tính tổng số đã bán (toàn bộ thời gian) chỉ cho sản phẩm có trạng thái 'delivered' hoặc 'completed'
        $paginatedProducts->getCollection()->transform(function ($product) {
            // Chỉ tính tổng số bán nếu sản phẩm có đơn hàng có trạng thái 'delivered' hoặc 'completed'
            $product->sold_this_period = $product->orderItems->filter(function ($orderItem) {
                // Kiểm tra trạng thái của đơn hàng liên kết với orderItem
                return in_array($orderItem->order->status, ['delivered', 'completed']);
            })->sum('quantity'); // Tính tổng số lượng bán được

            return $product;
        });



        return view('admin.pages.stocks.index', [
            'products' => $paginatedProducts,
        ]);
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

            if (empty($validated['variant_id'])) {
        // Sản phẩm đơn
        $stockBefore = (int) $product->quantity;

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
            'note' => $validated['note'] ?? null,
            'stock_before' => $stockBefore,
            'stock_after' => $product->quantity,
        ]);
    }
    else {
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