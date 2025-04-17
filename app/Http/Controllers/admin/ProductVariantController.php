<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Attribute;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        // Lấy danh sách các biến thể sản phẩm với các sản phẩm và giá trị thuộc tính
        $variants = ProductVariant::with('product', 'attributeValues.attribute')->latest()->paginate(10);
        return view('admin.product_variants.index', compact('variants'));
    }

    public function create()
    {
        // Lấy tất cả sản phẩm và các thuộc tính để chọn cho biến thể
        $products = Product::all();
        $attributes = Attribute::with('attributeValues')->get();
        return view('admin.product_variants.create', compact('products', 'attributes'));
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu nhập vào
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'required|unique:product_variants,sku',
            'variant_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        try {
            // Tạo mới biến thể sản phẩm
            $variant = ProductVariant::create([
                'product_id' => $request->product_id,
                'sku' => $request->sku,
                'variant_price' => $request->variant_price,
                'stock_quantity' => $request->stock_quantity,
            ]);

            // Đồng bộ giá trị thuộc tính nếu có
            if ($request->has('attribute_value_ids')) {
                $variant->attributeValues()->sync($request->attribute_value_ids);
            }

            // Quay lại trang danh sách với thông báo thành công
            return redirect()->route('product_variants.index')->with('success', 'Tạo biến thể thành công.');
        } catch (\Exception $e) {
            // Bắt lỗi và quay lại với thông báo lỗi
            return redirect()->route('product_variants.index')->with('error', 'Có lỗi xảy ra khi tạo biến thể.');
        }
    }

    public function edit($id)
    {
        // Lấy thông tin biến thể sản phẩm để chỉnh sửa
        $variant = ProductVariant::with('attributeValues')->findOrFail($id);
        $products = Product::all();
        $attributes = Attribute::with('attributeValues')->get();

        // Trả về trang chỉnh sửa với dữ liệu hiện tại
        return view('admin.product_variants.edit', compact('variant', 'products', 'attributes'));
    }

    public function update(Request $request, $id)
    {
        // Tìm biến thể sản phẩm cần cập nhật
        $variant = ProductVariant::findOrFail($id);

        // Xác thực dữ liệu nhập vào
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sku' => 'required|unique:product_variants,sku,' . $variant->id,
            'variant_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        try {
            // Cập nhật thông tin biến thể sản phẩm
            $variant->update([
                'product_id' => $request->product_id,
                'sku' => $request->sku,
                'variant_price' => $request->variant_price,
                'stock_quantity' => $request->stock_quantity,
            ]);

            // Đồng bộ giá trị thuộc tính nếu có
            $variant->attributeValues()->sync($request->attribute_value_ids ?: []);

            // Quay lại trang danh sách với thông báo thành công
            return redirect()->route('product_variants.index')->with('success', 'Cập nhật biến thể thành công.');
        } catch (\Exception $e) {
            // Bắt lỗi và quay lại với thông báo lỗi
            return redirect()->route('product_variants.index')->with('error', 'Có lỗi xảy ra khi cập nhật biến thể.');
        }
    }

    public function destroy($id)
    {
        // Tìm biến thể sản phẩm cần xóa
        $variant = ProductVariant::findOrFail($id);

        // Ngắt liên kết với giá trị thuộc tính trước khi xóa
        $variant->attributeValues()->detach();

        // Xóa biến thể sản phẩm
        $variant->delete();

        // Quay lại trang danh sách với thông báo thành công
        return redirect()->route('product_variants.index')->with('success', 'Xóa biến thể thành công.');
    }
}
