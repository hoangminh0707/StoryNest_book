<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;

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
        // 🔧 THÊM: Kiểm tra danh mục có được sản phẩm sử dụng không
        if ($this->categoryHasProducts($category->id)) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể sửa danh mục vì đang được sử dụng bởi sản phẩm.');
        }

        $categories = Categories::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.pages.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Categories $category)
    {
        // 🔧 THÊM: Kiểm tra danh mục có được sản phẩm sử dụng không
        if ($this->categoryHasProducts($category->id)) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể cập nhật danh mục vì đang được sử dụng bởi sản phẩm.');
        }

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
        // 🔧 SỬA: Kiểm tra qua bảng category_product thay vì products()
        if ($this->categoryHasProducts($category->id)) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục vì đang được sử dụng bởi sản phẩm.');
        }

        // 🔧 THÊM: Kiểm tra danh mục con
        if ($this->categoryHasChildren($category->id)) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục vì còn danh mục con.');
        }

        // Nếu không có sản phẩm và danh mục con → xóa
        $category->voucherConditions()->delete();
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }

    /**
     * 🔧 THÊM: Helper method kiểm tra danh mục có sản phẩm không
     */
    private function categoryHasProducts(int $categoryId): bool
    {
        return DB::table('category_product')
            ->where('category_id', $categoryId)
            ->exists();
    }

    /**
     * 🔧 THÊM: Helper method kiểm tra danh mục có danh mục con không
     */
    private function categoryHasChildren(int $categoryId): bool
    {
        return Categories::where('parent_id', $categoryId)->exists();
    }

}