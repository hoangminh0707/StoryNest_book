<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\AttributeValue;

class AttributeValueController extends Controller
{
    // Hiển thị danh sách giá trị thuộc tính + thuộc tính cha
    public function index()
    {
        $attributeValues = AttributeValue::with('attribute')->latest()->paginate(10);
        $attributes = Attribute::all();

        return view('admin.attributes.index', compact('attributeValues', 'attributes'));
    }

    // Hiển thị form thêm mới
    public function create()
    {
        $attributes = Attribute::all();
        return view('admin.attribute_values.create', compact('attributes'));
    }

    // Lưu giá trị thuộc tính mới
    public function store(Request $request)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
        ]);

        return redirect()->route('attribute_values.index')->with('success', 'Thêm giá trị thuộc tính thành công.');
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $value = AttributeValue::findOrFail($id);
        $attributes = Attribute::all();

        return view('admin.attribute_values.edit', compact('value', 'attributes'));
    }

    // Cập nhật giá trị thuộc tính
    public function update(Request $request, $id)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $value = AttributeValue::findOrFail($id);
        $value->update([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value,
        ]);

        return redirect()->route('attribute_values.index')->with('success', 'Cập nhật thành công.');
    }

    // Xóa giá trị thuộc tính
    public function destroy($id)
    {
        $value = AttributeValue::findOrFail($id);
        $value->delete();

        return redirect()->route('attribute_values.index')->with('success', 'Đã xóa giá trị.');
    }
}
