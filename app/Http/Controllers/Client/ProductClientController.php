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
use App\Models\Banner;



class ProductClientController extends Controller
{



    public function index()
    {
        $products = Product::with(['author', 'images'])
            ->where('status', 'published') // Chỉ lấy sản phẩm đã xuất bản
            ->get();

        $menuCategories = Categories::with('childrenRecursive')
            ->whereNull('parent_id')->get();

        $banners = Banner::whereNotNull('image_url')->get();

        $sachIds = Categories::where('parent_id', 1)->pluck('id')->toArray();
        $sachIds[] = 1;

        $doChoiIds = Categories::where('parent_id', 14)->pluck('id')->toArray();
        $doChoiIds[] = 14;

        $butVietIds = [9];

        $allGroupIds = array_merge($sachIds, $butVietIds, $doChoiIds);

        $productsByCategory = [
            'sach' => Product::where('status', 'published')
                ->whereHas('categories', function ($q) use ($sachIds) {
                    $q->whereIn('categories.id', $sachIds);
                })
                ->with(['author', 'images'])->get(),

            'butviet' => Product::where('status', 'published')
                ->whereHas('categories', function ($q) use ($butVietIds) {
                    $q->whereIn('categories.id', $butVietIds);
                })
                ->with(['author', 'images'])->get(),

            'dochoi' => Product::where('status', 'published')
                ->whereHas('categories', function ($q) use ($doChoiIds) {
                    $q->whereIn('categories.id', $doChoiIds);
                })
                ->with(['author', 'images'])->get(),

            'khac' => Product::where('status', 'published')
                ->whereDoesntHave('categories', function ($q) use ($allGroupIds) {
                    $q->whereIn('categories.id', $allGroupIds);
                })
                ->with(['author', 'images', 'categories'])->get(),
        ];

        return view('client.pages.index', compact('products', 'menuCategories', 'banners', 'productsByCategory'));
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
        $categories = Categories::with('childrenRecursive')->get();

        return view('client.pages.shop', compact('products', 'categories', 'authors'));
    }



    public function show($slug)
    {
        $product = Product::with(['author', 'categories', 'images', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $thumbnail = $product->images->where('is_thumbnail', 1)->first();
        $otherImages = $product->images->where('is_thumbnail', false);

        $variants = ProductVariant::where('product_id', $product->id)
            ->with('attributeValues.attribute')
            ->get();

        $groupedAttributes = [];
        foreach ($variants as $variant) {
            foreach ($variant->attributeValues as $attrValue) {
                $attributeName = $attrValue->attribute->name;
                $groupedAttributes[$attributeName][] = [
                    'variant_id' => $variant->id,
                    'value' => $attrValue->value,
                    'price' => $variant->variant_price,
                    'stock_quantity' => $variant->stock_quantity,
                ];
            }
        }

        $variants = $variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'variant_price' => $variant->variant_price,
                'price' => $variant->variant_price,
                'attribute_values' => $variant->attributeValues->map(function ($av) {
                    return [
                        'id' => $av->id,
                        'value' => $av->value,
                        'attribute' => ['name' => $av->attribute->name]
                    ];
                })
            ];
        });

        $categories = Categories::all();
        $products = Product::with(['author', 'categories', 'images'])->get();

        $productCategoryIds = $product->categories->pluck('id')->toArray();

        $vouchers = Voucher::where('is_active', 1)
            ->where(function ($query) use ($product, $productCategoryIds) {
                $query
                    ->whereDoesntHave('conditions')
                    ->orWhereHas('conditions', function ($q) use ($product, $productCategoryIds) {
                        $q->where(function ($cond) use ($product, $productCategoryIds) {
                            $cond
                                ->where(function ($q1) use ($product) {
                                    $q1->where('condition_type', 'product')->where('product_id', $product->id);
                                })
                                ->orWhere(function ($q2) use ($productCategoryIds) {
                                    $q2->where('condition_type', 'category')->whereIn('category_id', $productCategoryIds);
                                })
                                ->orWhere(function ($q3) use ($product, $productCategoryIds) {
                                    $q3->where('condition_type', 'product & category')
                                        ->where(function ($sub1) use ($product) {
                                            $sub1->where('product_id', $product->id)->orWhereNull('product_id');
                                        })
                                        ->where(function ($sub2) use ($productCategoryIds) {
                                            $sub2->whereIn('category_id', $productCategoryIds)->orWhereNull('category_id');
                                        });
                                })
                                ->orWhere(function ($q4) {
                                    $q4->where('condition_type', 'product')->whereNull('product_id');
                                })
                                ->orWhere(function ($q5) {
                                    $q5->where('condition_type', 'category')->whereNull('category_id');
                                });
                        });
                    });
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->with('conditions')
            ->get();

        // ✅ Xác định giá thấp nhất từ biến thể hoặc giá sản phẩm gốc
        $price = $variants->min('variant_price') ?? $product->price;

        // ✅ Tính voucher tốt nhất
        $bestVoucherObj = $vouchers->map(function ($voucher) use ($price) {
            $discount = 0;

            if (!is_null($voucher->min_order_value) && $price < $voucher->min_order_value) {
                return null;
            }

            if ($voucher->type === 'percent') {
                $discount = $price * ($voucher->value / 100);
                if ($voucher->max_discount_amount) {
                    $discount = min($discount, $voucher->max_discount_amount);
                }
            } elseif ($voucher->type === 'fixed') {
                $discount = $voucher->value;
            }

            return (object) [
                'voucher' => $voucher,
                'discount' => $discount,
            ];
        })
            ->filter()
            ->sortByDesc('discount')
            ->first();

        $bestVoucher = $bestVoucherObj ? $bestVoucherObj->voucher : null;
        $discountedPrice = $bestVoucherObj ? max($price - $bestVoucherObj->discount, 0) : $price;

        $averageRating = $product->reviews()->where('is_approved', true)->avg('rating');
        $canReview = false;
        if (auth()->check()) {
            $canReview = OrderItem::whereHas('order', function ($q) {
                $q->where('user_id', auth()->id())->where('status', 'delivered');
            })->where('product_id', $product->id)->exists();
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
            'bestVoucher',
            'discountedPrice',
            'averageRating',
            'canReview'
        ));
    }
