<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;

class CategoryAdminController extends Controller
{
    public function index()
    {
        $categories = Categories::with('parent')->latest()->paginate(10);
        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Categories::whereNull('parent_id')->get(); // Chỉ lấy danh mục cha
        return view('admin.pages.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Categories::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được thêm!');
    }

    public function edit(Categories $category)
    {
        $categories = Categories::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.pages.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Categories $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy(Categories $category)
    {
        // Kiểm tra nếu danh mục đang gán sản phẩm
        if ($category->products()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xoá danh mục vì đang chứa sản phẩm.');
        }

        // Nếu không có sản phẩm → xoá
        $category->voucherConditions()->delete();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã bị xóa thành công!');
    }

}