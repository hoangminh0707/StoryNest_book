<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Voucher;
// use App\Models\VoucherCondition;
// use App\Models\Product;
// use App\Models\Category;
// use Illuminate\Http\Request;

// class VoucherConditionController extends Controller
// {
//     /**
//      * Hiển thị danh sách điều kiện theo voucher
//      */
//     public function index($voucherId)
//     {
//         $voucher = Voucher::findOrFail($voucherId);
//         $conditions = $voucher->conditions()->with(['product', 'category'])->get();

//         return view('admin.voucher_conditions.index', compact('voucher', 'conditions'));
//     }

//     /**
//      * Hiển thị form tạo điều kiện mới
//      */
//     public function create($voucherId)
//     {
//         $voucher = Voucher::findOrFail($voucherId);
//         $products = Product::all();
//         $categories = Category::all();

//         return view('admin.voucher_conditions.create', compact('voucher', 'products', 'categories'));
//     }

//     /**
//      * Lưu điều kiện mới vào database
//      */
//     public function store(Request $request, $voucherId)
//     {
//         $voucher = Voucher::findOrFail($voucherId);

//         $validated = $request->validate([
//             'condition_type' => 'required|in:product,category',
//             'product_id' => 'nullable|exists:products,id',
//             'category_id' => 'nullable|exists:categories,id',
//         ]);

//         $validated['voucher_id'] = $voucher->id;

//         // Đảm bảo chỉ lưu product_id hoặc category_id tùy vào loại điều kiện
//         if ($validated['condition_type'] === 'product') {
//             $validated['category_id'] = null;
//         } else {
//             $validated['product_id'] = null;
//         }

//         VoucherCondition::create($validated);

//         return redirect()->route('admin.voucher-conditions.index', $voucher->id)
//                          ->with('success', 'Thêm điều kiện thành công!');
//     }

//     /**
//      * Hiển thị form chỉnh sửa điều kiện
//      */
//     public function edit($voucherId, $id)
//     {
//         $voucher = Voucher::findOrFail($voucherId);
//         $condition = VoucherCondition::findOrFail($id);
//         $products = Product::all();
//         $categories = Category::all();

//         return view('admin.voucher_conditions.edit', compact('voucher', 'condition', 'products', 'categories'));
//     }

//     /**
//      * Cập nhật điều kiện
//      */
//     public function update(Request $request, $voucherId, $id)
//     {
//         $condition = VoucherCondition::findOrFail($id);

//         $validated = $request->validate([
//             'condition_type' => 'required|in:product,category',
//             'product_id' => 'nullable|exists:products,id',
//             'category_id' => 'nullable|exists:categories,id',
//         ]);

//         // Giữ điều kiện hợp lệ
//         if ($validated['condition_type'] === 'product') {
//             $validated['category_id'] = null;
//         } else {
//             $validated['product_id'] = null;
//         }

//         $condition->update($validated);

//         return redirect()->route('admin.voucher-conditions.index', $voucherId)
//                          ->with('success', 'Cập nhật điều kiện thành công!');
//     }

//     /**
//      * Xóa điều kiện
//      */
//     public function destroy($voucherId, $id)
//     {
//         $condition = VoucherCondition::findOrFail($id);
//         $condition->delete();

//         return redirect()->route('admin.voucher-conditions.index', $voucherId)
//                          ->with('success', 'Xóa điều kiện thành công!');
//     }
// }
