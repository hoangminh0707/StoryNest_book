<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\Storage;

class ShippingMethodController extends Controller
{
    // Danh sách phương thức vận chuyển
    public function index(Request $request)
    {
        $query = ShippingMethod::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $shippingMethods = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.pages.shipping_methods.index', compact('shippingMethods'));
    }

    // Hiển thị form tạo mới
    public function create()
    {
        return view('admin.pages.shipping_methods.create');
    }

    // Lưu phương thức mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'default_fee' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'provider', 'default_fee', 'description']);
        $data['is_active'] = true;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('shipping_methods', 'public');
        }

        ShippingMethod::create($data);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Thêm phương thức vận chuyển thành công!');
    }

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $method = ShippingMethod::findOrFail($id);
        return view('admin.pages.shipping_methods.edit', compact('method'));
    }

    // Cập nhật phương thức
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider' => 'nullable|string|max:255',
            'default_fee' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $method = ShippingMethod::findOrFail($id);

        $data = $request->only(['name', 'provider', 'default_fee', 'description']);

        if ($request->hasFile('image')) {
            if ($method->image) {
                Storage::disk('public')->delete($method->image);
            }
            $data['image'] = $request->file('image')->store('shipping_methods', 'public');
        }

        $method->update($data);

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Cập nhật phương thức vận chuyển thành công!');
    }

    // Xóa phương thức
    public function destroy($id)
    {
        $method = ShippingMethod::findOrFail($id);

        if ($method->image) {
            Storage::disk('public')->delete($method->image);
        }

        $method->delete();

        return redirect()->route('admin.shipping-methods.index')->with('success', 'Xóa phương thức vận chuyển thành công!');
    }

    public function toggleStatus($id)
{
    $method = ShippingMethod::findOrFail($id);
    $method->is_active = !$method->is_active;
    $method->save();

    return back()->with('success', 'Trạng thái phương thức vận chuyển đã được cập nhật.');
}
}