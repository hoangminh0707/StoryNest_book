<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Voucher;
use App\Models\VoucherCondition;
use App\Models\Product;
use Illuminate\Http\Request;

class VoucherAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::with('conditions.product', 'conditions.category');

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->keyword . '%')
                    ->orWhere('name', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('expires_at')) {
            $query->whereDate('expires_at', $request->expires_at);
        }

        $vouchers = $query->latest()->paginate(10);

        return view('admin.pages.vouchers.index', compact('vouchers'));
    }


    public function create()
    {
        $products = Product::all();
        $categories = Categories::all();

        return view('admin.pages.vouchers.create', compact('products', 'categories'));
    }

    // Lưu voucher mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'max_usage' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'condition_type' => 'nullable|in:product,category',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Lưu voucher
        $voucher = Voucher::create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'value' => $validated['value'],
            'max_discount_amount' => $validated['max_discount_amount'] ?? null,
            'min_order_value' => $validated['min_order_value'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'max_usage' => $validated['max_usage'] ?? null,
            'usage_count' => 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'condition_type' => $validated['condition_type'] ?? null,
        ]);

        // Gắn điều kiện sản phẩm
        if (($validated['condition_type'] ?? null) === 'product') {
            foreach ($validated['product_ids'] ?? [] as $productId) {
                VoucherCondition::create([
                    'voucher_id' => $voucher->id,
                    'condition_type' => 'product',
                    'product_id' => $productId,
                ]);
            }
        }

        // Gắn điều kiện danh mục
        if (($validated['condition_type'] ?? null) === 'category') {
            foreach ($validated['category_ids'] ?? [] as $categoryId) {
                VoucherCondition::create([
                    'voucher_id' => $voucher->id,
                    'condition_type' => 'category',
                    'category_id' => $categoryId,
                ]);
            }
        }

        // dd($request->all());

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Tạo voucher thành công.');
    }




    public function toggleStatus($id)
    {
        // Tìm voucher theo ID
        $voucher = Voucher::findOrFail($id);

        // Thay đổi trạng thái hoạt động (is_active)
        $voucher->is_active = !$voucher->is_active;

        // Lưu thay đổi
        $voucher->save();

        // Trả về thông báo thành công và chuyển hướng lại trang danh sách
        return redirect()->route('admin.vouchers.index')->with('success', 'Trạng thái mã giảm giá đã được cập nhật.');
    }

    // Phương thức hiển thị form sửa voucher
    public function edit($id)
    {
        // Lấy voucher cần chỉnh sửa
        $voucher = Voucher::findOrFail($id);

        // Lấy tất cả sản phẩm để hiển thị trong select box
        $products = Product::all();
        $categories = Categories::all();

        // Truyền dữ liệu vào view
        return view('admin.pages.vouchers.edit', compact('voucher', 'products', 'categories'));
    }

    // Phương thức cập nhật voucher
    public function update(Request $request, $id)
    {
        // Lấy voucher theo id
        $voucher = Voucher::findOrFail($id);

        // Xử lý validate (nếu không dùng validator, chỉ sử dụng request validation inline)
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'max_usage' => 'nullable|numeric|min:1',
            'is_active' => 'nullable|boolean',
        ]);

        // Cập nhật thông tin voucher từ request
        $voucher->code = $request->input('code');
        $voucher->name = $request->input('name');
        $voucher->description = $request->input('description');
        $voucher->type = $request->input('type');
        $voucher->value = $request->input('value');
        $voucher->max_discount_amount = $request->input('max_discount_amount');
        $voucher->min_order_value = $request->input('min_order_value');
        $voucher->expires_at = $request->input('expires_at');
        $voucher->max_usage = $request->input('max_usage');
        $voucher->is_active = $request->has('is_active') ? 1 : 0;

        // Lưu lại thông tin voucher
        $voucher->save();

        // Quay lại trang danh sách voucher với thông báo thành công
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher đã được cập nhật thành công!');
    }

    public function show($id)
    {
        $voucher = Voucher::with([
            'conditions.product',
            'conditions.category',
            'usageLogs.user',
            'usageLogs.order'
        ])->findOrFail($id);

        return view('admin.pages.vouchers.show', compact('voucher'));
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->conditions()->delete();
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')->with('success', 'Xóa mã giảm giá thành công.');
    }
}