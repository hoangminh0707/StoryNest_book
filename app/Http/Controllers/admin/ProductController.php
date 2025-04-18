<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use App\Models\AttributeValue;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $status = $request->input('status', 'all');

        $products = Product::with(['category', 'author', 'publisher',  'variants.attributeValues.attribute', 'images'])
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
            })
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $counts = [
            'all' => Product::count(),
            'published' => Product::where('status', 'published')->count(),
            'draft' => Product::where('status', 'draft')->count(),
        ];

        return view('admin.products.index', compact('products', 'counts'));
    }

    // Hàm tạo mới sản phẩm
    public function create()
    {
        // Lấy các thuộc tính, danh mục, tác giả, nhà xuất bản
        $attributes = Attribute::with('values')->get();
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('admin.products.create', compact('attributes', 'categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        // Validation cho dữ liệu nhập
        $request->validate([
            'product_type' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.variant_price' => 'required_if:product_type,variable|numeric|min:0',
            'variants.*.stock_quantity' => 'required_if:product_type,variable|numeric|min:0',
            'variants.*.attribute_values' => 'required_if:product_type,variable|array',
            'variants.*.attribute_values.*' => 'required_if:product_type,variable|exists:attribute_values,id',
        ]);

        // Tạo sản phẩm
        $product = new Product();
        $product->name = $request->input('name');
        $product->product_type = $request->input('product_type');
        $product->category_id = $request->input('category_id');
        $product->author_id = $request->input('author_id');
        $product->publisher_id = $request->input('publisher_id');
        $product->status = $request->input('status', 'draft'); // Set default status
        $product->save();

        // Lưu hình ảnh nếu có
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                $imagePath = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_thumbnail' => false, // Đặt mặc định là không phải thumbnail
                ]);
            }
        }

        // Nếu sản phẩm là loại 'variable', tạo các biến thể
        if ($product->product_type === 'variable' && $request->has('variable') && is_array($request->input('variable'))) {
            foreach ($request->input('variable') as $variantData) {
                $variant = new ProductVariant();
                $variant->product_id = $product->id;
                $variant->variant_price = $variantData['variant_price'];
                $variant->stock_quantity = $variantData['stock_quantity'];
                $variant->save();
        
                if (!empty($variantData['attribute_values']) && is_array($variantData['attribute_values'])) {
                    foreach ($variantData['attribute_values'] as $valueId) {
                        ProductVariantAttribute::create([
                            'product_variant_id' => $variant->id,
                            'attribute_value_id' => $valueId,
                        ]);
                    }
                }
            }
        }
        
    
        // dd($request->all());
        // Redirect về trang danh sách sản phẩm với thông báo thành công
        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm và biến thể đã được tạo thành công.');
    }





    // protected function storeProductVariants(Product $product, Request $request)
    // {
    //     // Lưu biến thể cho sản phẩm
    //     $variantsData = $request->input('variants', []);
    //     foreach ($variantsData as $variantData) {
    //         $variant = new ProductVariant();
    //         $variant->product_id = $product->id;
    //         $variant->variant_name = $variantData['variant_name'];
    //         $variant->sku = $variantData['sku'];
    //         $variant->price = $variantData['price'];
    //         $variant->stock_quantity = $variantData['stock_quantity'];
    //         $variant->save();

    //         // Lưu các thuộc tính của biến thể
    //         $variant->attributes()->sync($variantData['attributes'] ?? []);
    //     }
    // }
    public function show($id)
    {
        // Lấy sản phẩm kèm theo các mối quan hệ cần thiết
        $product = Product::with([
            'category',
            'author',
            'publisher',
            'thumbnail',
            'images',
            'variants.attributeValues.attribute' // Lấy các biến thể và các thuộc tính của chúng
        ])->findOrFail($id); // Tìm sản phẩm hoặc trả về lỗi 404 nếu không tìm thấy

        return view('admin.products.show', compact('product'));
    }






    // public function destroy(Product $product)
    // {
    //     // Xóa tất cả hình ảnh liên quan đến sản phẩm trước khi xóa sản phẩm
    //     foreach ($product->images as $image) {
    //         Storage::disk('public')->delete($image->image_path);
    //         $image->delete();
    //     }

    //     // Xóa sản phẩm
    //     $product->delete();
    //     return back()->with('success', 'Xóa sản phẩm thành công!');
    // }

    // public function deleteImage($id)
    // {
    //     $image = ProductImage::findOrFail($id);
    //     Storage::disk('public')->delete($image->image_path);
    //     $image->delete();
    //     return back()->with('success', 'Xóa hình ảnh thành công!');
    // }
}
