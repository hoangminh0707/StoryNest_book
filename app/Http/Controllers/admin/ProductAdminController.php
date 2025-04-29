<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use App\Models\Attribute;
use App\Models\Categories;
use App\Models\Author;
use App\Models\Publisher;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $status  = $request->input('status', 'all');

        $products = Product::with(['categories', 'author', 'publisher', 'variants.attributeValues.attribute', 'images'])
            ->when($keyword, fn($q) => $q->where('name', 'like', "%{$keyword}%"))
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        $counts = [
            'all'       => Product::count(),
            'published' => Product::where('status', 'published')->count(),
            'draft'     => Product::where('status', 'draft')->count(),
        ];

        return view('admin.pages.products.index', compact('products', 'counts'));
    }

    public function create()
    {
        $attributes = Attribute::with('values')->get();
        $categories = Categories::with('childrenRecursive')->whereNull('parent_id')->get();
        $authors    = Author::all();
        $publishers = Publisher::all();

        return view('admin.pages.products.create', compact('attributes', 'categories', 'authors', 'publishers'));
    }


    public function store(Request $request)
    {
        // 1. Validate form, đã thêm rule cho 'description'
        $this->validateRequest($request);

        DB::beginTransaction();
        try {
            // 2. Tạo sản phẩm với cả description
            $product = Product::create(
                $this->buildProductData($request)
            );

            // 3.  danh mục
            $categoryIds = json_decode($request->category_ids, true) ?: [];
            $validCatIds = Categories::whereIn('id', $categoryIds)->pluck('id')->toArray();
            $product->categories()->sync($validCatIds);

            // 4. Lưu ảnh thumbnail + gallery
            $this->saveImages($request, $product);

            // 5. Lưu biến thể nếu loại variable
            if ($request->product_type === 'variable') {
                $this->saveVariants($request->variants, $product);
            }

            DB::commit();
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Lỗi khi lưu sản phẩm: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        $product = Product::with(['categories', 'author', 'publisher', 'images', 'variants.attributeValues.attribute'])
            ->findOrFail($id);

        $thumbnail     = $product->images->where('is_thumbnail', true)->first();
        $galleryImages = $product->images->where('is_thumbnail', false);

        return view('admin.pages.products.show', compact('product', 'thumbnail', 'galleryImages'));
    }

    public function edit($id)
    {
        $product = Product::with(['categories', 'images', 'variants.attributeValues.attribute'])->findOrFail($id);

        // IDs của danh mục đã chọn
        $selectedCategoryIds = $product->categories->pluck('id')->toArray();

        // Load cây danh mục cha-con
        $categories = Categories::with('childrenRecursive')
            ->whereNull('parent_id')
            ->get();

        $attributes = Attribute::with('values')->get();
        $authors    = Author::all();
        $publishers = Publisher::all();

        $thumbnail     = $product->images->firstWhere('is_thumbnail', true);
        $galleryImages = $product->images->where('is_thumbnail', false);

        return view('admin.pages.products.edit', compact(
            'product',
            'attributes',
            'categories',
            'authors',
            'publishers',
            'selectedCategoryIds',
            'thumbnail',
            'galleryImages'
        ));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, $id);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->update(
                $this->buildProductData($request)
            );

            $this->syncCategories($product, $request->input('category_ids'));
            $this->saveImages($request, $product);

            $product->variants()->delete();
            if ($request->product_type === 'variable') {
                $this->saveVariants($request->variants, $product);
            }

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with(['variants.attributeValues', 'images', 'categories', 'cartItems', 'orderItems', 'reviews', 'wishlists'])
                ->findOrFail($id);

            $product->voucherConditions()->delete();
            $product->cartItems()->delete();
            $product->orderItems()->delete();
            foreach ($product->variants as $variant) {
                $variant->attributeValues()->detach();
                $variant->delete();
            }
            $product->reviews()->delete();
            $product->wishlists()->delete();

            foreach ($product->images as $img) {
                Storage::delete('public/' . $img->image_path);
                $img->delete();
            }

            $product->categories()->detach();
            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Sản phẩm đã được xóa thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi khi xóa sản phẩm: ' . $e->getMessage());
        }
    }

    // ========== SUPPORT METHODS ==========

    private function validateRequest(Request $request, $id = null)
    {
        $rules = [
            'product_type' => 'required|in:simple,variable',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:300',
            'price'        => 'nullable|numeric|min:0.01',
            'quantity'     => 'nullable|integer|min:1',
            'category_ids' => 'nullable|json|min:1',
            'author_id'    => 'nullable|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'status'       => 'required|in:published,draft',
            'thumbnail'    => $id
                ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants'                  => 'nullable|array',
            'variants.*.variant_price'  => 'required_if:product_type,variable|numeric|min:0.01',
            'variants.*.stock_quantity' => 'required_if:product_type,variable|integer|min:1',
            'variants.*.attribute_values'      => 'required_if:product_type,variable|array',
            'variants.*.attribute_values.*'    => 'exists:attribute_values,id',
        ];

        $request->validate($rules);
    }

    private function buildProductData(Request $request): array
    {
        $data = [
            'name'         => $request->name,
            'description'  => $request->description,
            'product_type' => $request->product_type,
            'author_id'    => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'status'       => $request->status,
        ];

        if ($request->product_type === 'simple') {
            $data['price']    = $request->price;
            $data['quantity'] = $request->quantity;
        } else {
            $data['price']    = null;
            $data['quantity'] = null;
        }

        return $data;
    }

    private function syncCategories(Product $product, ?string $jsonIds)
    {
        $ids   = json_decode($jsonIds, true) ?: [];
        $valid = Categories::whereIn('id', $ids)->pluck('id')->toArray();
        $product->categories()->sync($valid);
    }

    private function saveImages(Request $request, Product $product)
    {
        if ($request->has('delete_gallery')) {
            foreach ($request->delete_gallery as $imgId) {
                $img = ProductImage::find($imgId);
                if ($img) {
                    Storage::delete('public/' . $img->image_path);
                    $img->delete();
                }
            }
        }

        if ($request->hasFile('thumbnail')) {
            $old = $product->images()->where('is_thumbnail', true)->first();
            if ($old) {
                Storage::delete('public/' . $old->image_path);
                $old->delete();
            }
            $file = $request->file('thumbnail');
            $name = time() . '_thumb_' . $file->getClientOriginalName();
            $file->storeAs('public/products', $name);
            ProductImage::create(['product_id' => $product->id, 'image_path' => 'products/' . $name, 'is_thumbnail' => true]);
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $name = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/products', $name);
                ProductImage::create(['product_id' => $product->id, 'image_path' => 'products/' . $name, 'is_thumbnail' => false]);
            }
        }
    }

    private function saveVariants(array $variants, Product $product)
    {
        foreach ($variants as $item) {
            $variant = ProductVariant::create([
                'product_id'    => $product->id,
                'variant_price' => $item['variant_price'],
                'stock_quantity' => $item['stock_quantity'],
            ]);
            foreach ($item['attribute_values'] ?? [] as $valId) {
                ProductVariantAttribute::create([
                    'product_variant_id' => $variant->id,
                    'attribute_value_id' => $valId,
                ]);
            }
        }
    }
       
    public function bulkDelete(Request $request)
    {
        $ids = explode(',', $request->input('ids'));

        // Nếu cần kiểm tra thêm: chỉ xóa sản phẩm thuộc quyền quản lý
        Product::whereIn('id', $ids)->delete();

        return redirect()->route('admin.products.index')->with('success', 'Đã xóa các sản phẩm đã chọn.');
    }

}
