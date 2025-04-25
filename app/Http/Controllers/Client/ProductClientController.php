<?php

namespace App\Http\Controllers\Client;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Author;
use App\Models\ProductVariant;
use Carbon\Carbon;
use App\Models\Voucher;


class ProductClientController extends Controller
{



    public function index()
    {
        $products = Product::with([
            'author',
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ])->get();

        $categories = Category::all();

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
        $categories = Category::all();

        return view('client.pages.shop', compact('products', 'categories', 'authors'));
    }



    public function show($id)
    {
        $products = Product::with([
            'author',
            'categories', // thêm dòng này để load danh mục của sản phẩm
            'images' => function ($query) {
                $query->where('is_thumbnail', true);
            }
        ])->get();

        $categories = Category::all();

        $product = Product::with(['author', 'categories', 'images'])->findOrFail($id);

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
                $groupedAttributes[$attributeName][$attrValue->id] = $attrValue->value;
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
                    // Điều kiện voucher áp dụng cho mọi sản phẩm
                    ->whereHas('conditions', function ($q) {
                        $q->where('condition_type', 'product')->whereNull('product_id');
                    })
                    // Điều kiện voucher áp dụng cho mọi danh mục
                    ->orWhereHas('conditions', function ($q) {
                        $q->where('condition_type', 'category')->whereNull('category_id');
                    })
                    // Điều kiện voucher áp dụng cụ thể theo sản phẩm
                    ->orWhereHas('conditions', function ($q) use ($product) {
                        $q->where('condition_type', 'product')->where('product_id', $product->id);
                    })
                    // Điều kiện voucher áp dụng cụ thể theo danh mục
                    ->orWhereHas('conditions', function ($q) use ($productCategoryIds) {
                        $q->where('condition_type', 'category')->whereIn('category_id', $productCategoryIds);
                    })
                    // Điều kiện voucher áp dụng cả sản phẩm và danh mục cụ thể
                    ->orWhereHas('conditions', function ($q) use ($product, $productCategoryIds) {
                        $q->where('condition_type', 'product & category')
                            ->where(function ($sub) use ($product) {
                                $sub->where('product_id', $product->id)->orWhereNull('product_id');
                            })
                            ->where(function ($sub) use ($productCategoryIds) {
                                $sub->whereIn('category_id', $productCategoryIds)->orWhereNull('category_id');
                            });
                    });
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', Carbon::now());
            })
            ->get();


        return view('client.pages.product', compact('product', 'thumbnail', 'otherImages', 'products', 'categories', 'variants', 'groupedAttributes', 'vouchers'));


    }


}