<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Http\Request;



class AttributeAdminController extends Controller
{
    // Hiển thị danh sách thuộc tính và giá trị thuộc tính
    public function index()
    {
        // Lấy tất cả thuộc tính và giá trị thuộc tính
        $attributes = Attribute::all();
        $attributeValues = AttributeValue::with(['attribute'])->latest()->paginate(10);

        // Trả về view kèm theo dữ liệu
        return view('admin.pages.attributes.index', compact('attributes', 'attributeValues'));
    }

    // Hiển thị form tạo mới thuộc tính
    public function create()
    {
        return view('admin.pages.attributes.create');
    }

    // Lưu thuộc tính mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Attribute::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.attributes.index')->with('success', 'Thuộc tính đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa thuộc tính
    public function edit($id)
    {
        $attribute = Attribute::with('values.productVariants')->findOrFail($id);

        // Kiểm tra nếu bất kỳ value nào được dùng trong sản phẩm
        $hasUsedValue = $attribute->values->contains(function ($value) {
            return $value->productVariants->isNotEmpty();
        });

        if ($hasUsedValue) {
            return redirect()->route('admin.attributes.index')
                ->with('error', 'Thuộc tính có giá trị đã được sử dụng trong sản phẩm, không thể chỉnh sửa!');
        }

        return view('admin.pages.attributes.edit', compact('attribute'));
    }


    // Cập nhật thuộc tính
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.attributes.index')->with('success', 'Thuộc tính đã được cập nhật!');
    }

    // Xóa thuộc tính
    public function destroy($id)
    {
        $attribute = Attribute::with('values.productVariants')->findOrFail($id);

        // Kiểm tra nếu bất kỳ giá trị nào của thuộc tính đã được dùng trong sản phẩm
        $hasUsedValue = $attribute->values->contains(function ($value) {
            return $value->productVariants->isNotEmpty();
        });

        if ($hasUsedValue) {
            return redirect()->route('admin.attributes.index')
                ->with('error', 'Không thể xóa thuộc tính vì có giá trị đã được sử dụng trong sản phẩm.');
        }

        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Thuộc tính đã được xóa!');
    }


}