<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\categories;
use App\Models\Author;
use App\Models\ProductVariant;
use Carbon\Carbon;
use App\Models\Voucher;
use App\Models\OrderItem;


class ProductClientController extends Controller
{



    public function index()
    {
        $products = Product::with(['author', 'images'])->get();
        $categories = categories::all();

        return view('client.pages.index', compact('products', 'categories'));
    }


    public function shop(Request $request)
    {
        $query = Product::with([
            'author',
            'categories',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ]);

        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }


        if ($request->has('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }



        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        $products = $query->paginate(12);



        $authors = Author::all();
        $categories = categories::all();

        return view('client.pages.shop', compact('products', 'categories', 'authors'));
    }



    public function show($id)
    {
        $products = Product::with([
            'author',
            'categories', // thêm dòng này để load danh mục của sản phẩm
            'images',
        ])->get();

        $categories = categories::all();

        $product = Product::with([
            'author',
            'categories',
            'images',
            'reviews.user' // ✏️ Thêm để lấy luôn tên người đánh giá
        ])->findOrFail($id);

        $thumbnail = $product->images->where('is_thumbnail', 1)->first();
        $otherImages = $product->images->where('is_thumbnail', false);

        $variants = ProductVariant::where('product_id', $product->id)
            ->with('attributeValues.attribute') // lấy tên thuộc tính + giá trị
            ->get();

        // Gom nhóm theo tên thuộc tính
        $groupedAttributes = [];

        foreach ($variants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                $attributeName = $attrValue->attribute->name;
                $groupedAttributes[$attributeName][] = [
                    'variant_id' => $variant->id,
                    'value' => $attrValue->value,
                    'price' => $variant->variant_price
                ];
            }
        }


        $variants = $variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'variant_price' => $variant->variant_price,
                'price' => $variant->variant_price, // thêm dòng này để JS dùng 'price'
                'attribute_values' => $variant->attributeValues->map(function ($av) {
                    return [
                        'id' => $av->id,
                        'value' => $av->value,
                        'attribute' => [
                            'name' => $av->attribute->name
                        ]
                    ];
                })
            ];
        });




        $productCategoryIds = $product->categories->pluck('id')->toArray();

        $vouchers = Voucher::where('is_active', 1)
            ->where(function ($query) use ($product, $productCategoryIds) {
                $query
                    // 1. Voucher không có điều kiện nào (áp dụng toàn bộ)
                    ->whereDoesntHave('conditions')
                    // 2. Hoặc có điều kiện phù hợp
                    ->orWhereHas('conditions', function ($q) use ($product, $productCategoryIds) {
                        $q->where(function ($cond) use ($product, $productCategoryIds) {
                            $cond
                                // Sản phẩm cụ thể
                                ->where(function ($q1) use ($product) {
                                    $q1->where('condition_type', 'product')->where('product_id', $product->id);
                                })
                                // Danh mục cụ thể
                                ->orWhere(function ($q2) use ($productCategoryIds) {
                                    $q2->where('condition_type', 'category')->whereIn('category_id', $productCategoryIds);
                                })
                                // Áp dụng kết hợp sản phẩm & danh mục
                                ->orWhere(function ($q3) use ($product, $productCategoryIds) {
                                    $q3->where('condition_type', 'product & category')
                                        ->where(function ($sub1) use ($product) {
                                            $sub1->where('product_id', $product->id)->orWhereNull('product_id');
                                        })
                                        ->where(function ($sub2) use ($productCategoryIds) {
                                            $sub2->whereIn('category_id', $productCategoryIds)->orWhereNull('category_id');
                                        });
                                })
                                // Áp dụng toàn bộ sản phẩm (product_id null)
                                ->orWhere(function ($q4) {
                                    $q4->where('condition_type', 'product')->whereNull('product_id');
                                })
                                // Áp dụng toàn bộ danh mục (category_id null)
                                ->orWhere(function ($q5) {
                                    $q5->where('condition_type', 'category')->whereNull('category_id');
                                });
                        });
                    });
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
            })
            ->get();


        // 🎯 Thêm: tính trung bình rating
        $averageRating = $product->reviews()->where('is_approved', true)->avg('rating');

        // 🎯 Thêm: kiểm tra quyền đánh giá
        $canReview = false;
        if (auth()->check()) {
            $canReview = OrderItem::whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())
                    ->where('status', 'completed');
            })
                ->where('product_id', $product->id)
                ->exists();
        }


        return view('client.pages.product', compact(
            'product',
            'thumbnail',
            'otherImages',
            'products',
            'categories',
            'variants',
            'groupedAttributes',
            'vouchers',
            'averageRating',
            'canReview'
        ));

    }
    public function about()
    {
        return view('client.pages.about');
    }


}