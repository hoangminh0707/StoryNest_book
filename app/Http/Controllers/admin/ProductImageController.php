<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index()
    {
        $images = ProductImage::with('product')->paginate(10);
        return view('admin.product_images.index', compact('images'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.product_images.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        foreach ($request->file('images') as $index => $imageFile) {
            $path = $imageFile->store('product_images', 'public');

            ProductImage::create([
                'product_id' => $request->product_id,
                'image_path' => $path,
                'is_thumbnail' => $request->has('thumbnail_index') && $index === 0 ? 1 : 0,
            ]);
        }

        return redirect()->route('product-images.index')->with('success', 'Đã thêm hình ảnh thành công.');
    }

    public function edit(ProductImage $productImage)
    {
        $products = Product::all();
        return view('admin.product_images.edit', [
            'image' => $productImage,
            'products' => $products
        ]);
    }

    public function update(Request $request, ProductImage $productImage)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($productImage->image_path);
            $productImage->image_path = $request->file('image')->store('product_images', 'public');
        }

        $productImage->update([
            'product_id' => $request->product_id,
            'is_thumbnail' => $request->has('is_thumbnail'),
        ]);

        return redirect()->route('product-images.index')->with('success', 'Cập nhật hình ảnh thành công.');
    }

    public function destroy(ProductImage $productImage)
    {
        Storage::disk('public')->delete($productImage->image_path);
        $productImage->delete();

        return back()->with('success', 'Xóa hình ảnh thành công.');
    }
}