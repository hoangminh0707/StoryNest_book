<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $status = $request->input('status', 'all');

        $products = Product::with(['categories', 'author', 'publisher', 'variants.attributeValues.attribute', 'images'])
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

        return view('admin.pages.products.index', compact('products', 'counts'));
    }

    // Hàm tạo mới sản phẩm
    public function create()
    {
        // Lấy các thuộc tính, danh mục, tác giả, nhà xuất bản
        $attributes = Attribute::with('values')->get();
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('admin.pages.products.create', compact('attributes', 'categories', 'authors', 'publishers'));
    }

    public function store(Request $request)
    {
        // Bước 1: Validate
        $request->validate([
            'product_type' => 'required|in:simple,variable',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_ids' => 'required|string',
            'author_id' => 'nullable|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'status' => 'required|in:published,draft',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Biến thể
            'variants' => 'nullable|array',
            'variants.*.variant_price' => 'required_if:product_type,variable|numeric|min:0',
            'variants.*.stock_quantity' => 'required_if:product_type,variable|integer|min:0',
            'variants.*.attribute_values' => 'required_if:product_type,variable|array',
            'variants.*.attribute_values.*' => 'exists:attribute_values,id',
        ]);

        try {
            // Bước 2: Tạo sản phẩm
            $product = new Product();
            $product->name = $request->name;
            $product->product_type = $request->product_type;
            $product->author_id = $request->author_id;
            $product->publisher_id = $request->publisher_id;
            $product->status = $request->status ?? 'draft';



            // Nếu là sản phẩm đơn giản, lưu giá và số lượng
            if ($request->product_type === 'simple') {
                $product->price = $request->price;
                $product->quantity = $request->quantity;
            }

            $product->save();
            // Gắn danh mục vào sản phẩm
            $categoryIds = json_decode($request->input('category_ids'), true);
            $product->categories()->attach($categoryIds);

            // Lưu ảnh chính (thumbnail)
            if ($request->hasFile('thumbnail')) {
                $thumb = $request->file('thumbnail');
                $thumbName = time() . '_thumb_' . $thumb->getClientOriginalName();
                $thumbPath = $thumb->storeAs('public/products', $thumbName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/products/' . $thumbName,
                    'is_thumbnail' => true,
                ]);
            }

            // Lưu ảnh phụ (gallery)
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $imagePath = $image->storeAs('public/products', $imageName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'storage/products/' . $imageName,
                        'is_thumbnail' => false,
                    ]);
                }
            }

            // Bước 3: Lưu biến thể nếu có (dành cho sản phẩm biến thể)
            if ($request->product_type === 'variable' && is_array($request->variants)) {
                foreach ($request->variants as $variantData) {
                    $variant = new ProductVariant();
                    $variant->product_id = $product->id;
                    $variant->variant_price = $variantData['variant_price'];
                    $variant->stock_quantity = $variantData['stock_quantity'];
                    $variant->save();

                    // Lưu các thuộc tính cho biến thể
                    if (!empty($variantData['attribute_values'])) {
                        foreach ($variantData['attribute_values'] as $valueId) {
                            ProductVariantAttribute::create([
                                'product_variant_id' => $variant->id,
                                'attribute_value_id' => $valueId,
                            ]);
                        }
                    }
                }
            }

            // Chuyển hướng về trang danh sách sản phẩm với thông báo thành công
            return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            // Ghi log nếu cần: Log::error($e);
            // Trả về trang trước với thông báo lỗi
            return back()->withInput()->with('error', 'Đã xảy ra lỗi khi lưu sản phẩm: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        // Lấy sản phẩm kèm theo các mối quan hệ cần thiết
        $product = Product::with([
            'categories',
            'author',
            'publisher',
            'thumbnail',
            'images',
            'variants.attributeValues.attribute' // Lấy các biến thể và các thuộc tính của chúng
        ])->findOrFail($id); // Tìm sản phẩm hoặc trả về lỗi 404 nếu không tìm thấy
        // dd($product->categories);

        return view('admin.pages.products.show', compact('product'));
    }


    public function edit($id)
    {

        // Lấy sản phẩm cùng các mối quan hệ liên quan
        $product = Product::with([
            'categories',
            'images',
            'variants.attributeValues.attribute',
        ])->findOrFail($id);

        // Danh sách danh mục đã chọn (ID)
        $selectedCategoryIds = $product->categories->pluck('id')->toArray();

        // Lấy dữ liệu cần cho form
        $attributes = Attribute::with('values')->get();
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        // Phân loại ảnh
        $thumbnail = $product->images->firstWhere('is_thumbnail', true);
        $galleryImages = $product->images->where('is_thumbnail', false);

        // Trả về view
        return view('admin.pages.products.edit', compact(
            'product',
            'categories',
            'attributes',
            'authors',
            'publishers',
            'thumbnail',
            'galleryImages',
            'selectedCategoryIds'
        ));
    }

    public function update(Request $request, $id)
    {
        dd($request->all());
        $request->validate([
            'product_type' => 'required|in:simple,variable',
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'category_ids' => 'required|string',
            'author_id' => 'nullable|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'status' => 'required|in:published,draft',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Biến thể
            'variants' => 'nullable|array',
            'variants.*.variant_price' => 'required_if:product_type,variable|numeric|min:0',
            'variants.*.stock_quantity' => 'required_if:product_type,variable|integer|min:0',
            'variants.*.attribute_values' => 'required_if:product_type,variable|array',
            'variants.*.attribute_values.*' => 'exists:attribute_values,id',

        ]);

        try {
            $product = Product::findOrFail($id);
            $product->name = $request->name;
            $product->product_type = $request->product_type;
            $product->author_id = $request->author_id;
            $product->publisher_id = $request->publisher_id;
            $product->status = $request->status;

            if ($request->product_type === 'simple') {
                $product->price = $request->price;
                $product->quantity = $request->quantity;
            } else {
                $product->price = null;
                $product->quantity = null;
            }

            $product->save();

            // Cập nhật danh mục
            $categoryIds = json_decode($request->input('category_ids'), true);
            $product->categories()->sync($categoryIds);

            // Cập nhật thumbnail nếu có
            if ($request->hasFile('thumbnail')) {
                // Xóa thumbnail cũ
                $oldThumb = $product->images()->where('is_thumbnail', true)->first();
                if ($oldThumb) {
                    Storage::delete(str_replace('storage/', 'public/', $oldThumb->image_path));
                    $oldThumb->delete();
                }

                // Lưu thumbnail mới
                $thumb = $request->file('thumbnail');
                $thumbName = time() . '_thumb_' . $thumb->getClientOriginalName();
                $thumbPath = $thumb->storeAs('public/products', $thumbName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => 'storage/products/' . $thumbName,
                    'is_thumbnail' => true,
                ]);
            }
            // Xử lý xóa ảnh cũ nếu người dùng chọn
            if ($request->has('delete_gallery')) {
                foreach ($request->delete_gallery as $imageId) {
                    $image = ProductImage::find($imageId);
                    if ($image) {
                        Storage::delete(str_replace('storage/', 'public/', $image->image_path));
                        $image->delete();
                    }
                }
            }

            // Thêm ảnh mới nếu có
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->storeAs('public/products', $imageName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'storage/products/' . $imageName,
                        'is_thumbnail' => false,
                    ]);
                }
            }


        

            if ($request->product_type === 'variable') {
                $existingVariantIds = $product->variants->pluck('id')->toArray(); // Lấy các ID biến thể hiện tại
                $submittedVariantIds = []; // Mảng chứa các ID biến thể từ form gửi lên

                if (!empty($request->variants)) {
                    foreach ($request->variants as $variantIndex => $variantData) {
                        $variantId = $variantData['id'] ?? null;
                        $variantPrice = $variantData['variant_price'];
                        $stockQuantity = $variantData['stock_quantity'];
                        $attributeValues = $variantData['attribute_values'];

                        // Nếu có ID, cập nhật biến thể cũ
                        if ($variantId) {
                            $variant = ProductVariant::find($variantId);
                            if ($variant && $variant->product_id == $product->id) {
                                // Cập nhật giá và số lượng của biến thể
                                $variant->variant_price = $variantPrice;
                                $variant->stock_quantity = $stockQuantity;
                                $variant->save();

                                // Xóa các thuộc tính cũ của biến thể (trong bảng trung gian)
                                $variant->attributes()->detach();

                                // Gắn lại các thuộc tính mới cho biến thể
                                foreach ($attributeValues as $valueId) {
                                    ProductVariantAttribute::create([
                                        'product_variant_id' => $variant->id,
                                        'attribute_value_id' => $valueId,
                                    ]);
                                }

                                $submittedVariantIds[] = $variant->id;
                            }
                        } else {
                            // Nếu không có ID, tạo mới biến thể
                            $variant = new ProductVariant();
                            $variant->product_id = $product->id;
                            $variant->variant_price = $variantPrice;
                            $variant->stock_quantity = $stockQuantity;
                            $variant->save();

                            // Gắn các thuộc tính cho biến thể mới
                            foreach ($attributeValues as $valueId) {
                                ProductVariantAttribute::create([
                                    'product_variant_id' => $variant->id,
                                    'attribute_value_id' => $valueId,
                                ]);
                            }

                            $submittedVariantIds[] = $variant->id;
                        }
                    }
                }

                // Xóa những biến thể không còn trong form gửi lên
                $variantsToDelete = array_diff($existingVariantIds, $submittedVariantIds);
                if (!empty($variantsToDelete)) {
                    foreach ($variantsToDelete as $variantId) {
                        $variant = ProductVariant::find($variantId);
                        if ($variant) {
                            // Xóa các thuộc tính liên quan đến biến thể
                            $variant->attributes()->detach();
                            // Xóa biến thể
                            $variant->delete();
                        }
                    }
                }
            }






            return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Đã xảy ra lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // 1. Lấy Product kèm các quan hệ cần thiết
            $product = Product::with([
                'voucherConditions',
                'cartItems',
                'orderItems',
                'productAttributes',
                'variants.attributeValues',
                'reviews',
                'wishlists',
                'images',
                'categories',
            ])->findOrFail($id);

            // 2. Xóa voucher_conditions
            $product->voucherConditions()->delete();

            // 3. Xóa cart_items và order_items
            $product->cartItems()->delete();
            $product->orderItems()->delete();

            // 4. Xóa product_attribute (bảng trung gian Attribute)
            $product->productAttributes()->delete();

            // 5. Xóa variants và detach thuộc tính
            foreach ($product->variants as $variant) {
                $variant->attributeValues()->detach();      // bảng product_variant_attributes
                $variant->delete();                         // bảng product_variants
            }

            // 6. Xóa reviews và wishlists
            $product->reviews()->delete();
            $product->wishlists()->delete();

            // 7. Xóa images (thumbnail + gallery)
            foreach ($product->images as $image) {
                $path = str_replace('storage/', 'public/', $image->image_path);
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
                $image->delete();
            }

            // 8. Xóa liên kết categories (bảng trung gian)
            $product->categories()->detach();

            // 9. Cuối cùng xóa chính sản phẩm
            $product->delete();

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Sản phẩm và toàn bộ dữ liệu liên quan đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Đã xảy ra lỗi khi xóa sản phẩm: ' . $e->getMessage());
        }
    }
}
