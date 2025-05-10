<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'author', 'publisher', 'images'])->latest()->paginate(10);
    
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('admin.products.create', compact('categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Tạo sản phẩm mới
        $product = Product::create($validated);

        // Lưu hình ảnh nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_thumbnail' => $index === 0 // Đánh dấu hình ảnh đầu tiên là thumbnail
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('admin.products.edit', compact('product', 'categories', 'authors', 'publishers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|max:10240',
            'delete_images' => 'nullable|array' // Xử lý xóa hình ảnh cũ
        ]);

        // Cập nhật thông tin sản phẩm
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
        ]);

        // Xóa hình ảnh cũ nếu có
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::findOrFail($imageId);
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        // Lưu hình ảnh mới nếu có
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('product_images', 'public');

                // Tạo một bản ghi mới cho mỗi hình ảnh
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_thumbnail' => $index === 0 // Đánh dấu hình ảnh đầu tiên là thumbnail
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        // Xóa tất cả hình ảnh liên quan đến sản phẩm trước khi xóa sản phẩm
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Xóa sản phẩm
        $product->delete();
        return back()->with('success', 'Xóa sản phẩm thành công!');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Xóa hình ảnh thành công!');
    }
}
