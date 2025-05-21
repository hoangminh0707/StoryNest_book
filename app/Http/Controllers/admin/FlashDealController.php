<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\FlashSaleProductVariant;
use Illuminate\Http\Request;

class FlashDealController extends Controller
{
    public function index(Request $request)
    {
        $query = FlashDeal::query();

        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        $flashDeals = $query->orderBy('created_at', 'desc')->paginate(10);
        $flashDeals->appends($request->only(['search_title']));

        return view('admin.pages.flash_deals.index', compact('flashDeals'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.pages.flash_deals.create', compact('products'));
    }

    public function getVariants(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $variants = ProductVariant::with('attributeValues.attribute')
            ->where('product_id', $request->product_id)
            ->get();

        $data = $variants->map(function ($variant) {
            $variantName = $variant->attributeValues->map(function ($value) {
                return $value->attribute->name . ': ' . $value->value;
            })->implode(' - ');

            return [
                'id' => $variant->id,
                'name' => $variantName ?: 'Biến thể không rõ',
                'price' => $variant->variant_price,
            ];
        });

        return response()->json($data);
    }

   protected function validateFlashDeal(Request $request)
{
    $messages = [
        'title.required' => 'Tiêu đề không được để trống.',
        'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
        'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
        'start_time.required' => 'Thời gian bắt đầu không được để trống.',
        'start_time.date' => 'Thời gian bắt đầu phải là định dạng ngày hợp lệ.',
        'end_time.required' => 'Thời gian kết thúc không được để trống.',
        'end_time.date' => 'Thời gian kết thúc phải là định dạng ngày hợp lệ.',
        'end_time.after_or_equal' => 'Thời gian kết thúc phải lớn hơn hoặc bằng thời gian bắt đầu.',
        'usage_limit.integer' => 'Giới hạn lượt dùng phải là số nguyên.',
        'usage_limit.min' => 'Giới hạn lượt dùng phải lớn hơn hoặc bằng 1.',
        'product_id.required' => 'Bạn phải chọn sản phẩm.',
        'product_id.exists' => 'Sản phẩm được chọn không tồn tại.',
        'variant_ids.array' => 'Dữ liệu biến thể không hợp lệ.',
        'variant_ids.min' => 'Bạn phải chọn ít nhất một biến thể.',
        'variant_ids.*.exists' => 'Biến thể được chọn không tồn tại.',
        'discount_percent.required' => 'Phần trăm giảm giá không được để trống.',
        'discount_percent.numeric' => 'Phần trăm giảm giá phải là số.',
        'discount_percent.min' => 'Phần trăm giảm giá phải lớn hơn hoặc bằng 1%.',
        'discount_percent.max' => 'Phần trăm giảm giá không được vượt quá 100%.',
    ];

    $rules = [
        'title' => ['required', 'string', 'max:255'],
        'start_time' => ['required', 'date'],
        'end_time' => ['required', 'date', 'after_or_equal:start_time'],
        'usage_limit' => ['nullable', 'integer', 'min:1'],
        'product_id' => ['required', 'exists:products,id'],
        'variant_ids' => ['nullable', 'array', 'min:1'],
        'variant_ids.*' => ['exists:product_variants,id'],
        'discount_percent' => ['required', 'numeric', 'min:1', 'max:100'],
    ];

    // Kiểm tra sản phẩm có biến thể không và điều chỉnh yêu cầu 'variant_ids'
    $product = Product::find($request->product_id);
    if ($product && $product->variants->count() == 0) {
        // Nếu sản phẩm không có biến thể, không cần yêu cầu chọn 'variant_ids'
        $rules['variant_ids'] = 'nullable';
    }

    return $request->validate($rules, $messages);
}


   public function store(Request $request)
{
    $validated = $this->validateFlashDeal($request);

    $flashDeal = FlashDeal::create([
        'title' => $request->title,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'usage_limit' => $request->usage_limit ?? 0,
        'used_count' => 0,
    ]);

    $product = Product::find($request->product_id);

    // Kiểm tra sản phẩm có biến thể không
    if ($product->variants()->count() > 0) {
        // Có biến thể: xử lý theo biến thể được chọn
        $variants = ProductVariant::whereIn('id', $request->variant_ids ?? [])->get();

        foreach ($variants as $variant) {
            $discountPrice = round($variant->variant_price * (1 - $request->discount_percent / 100), 2);

            FlashSaleProductVariant::updateOrCreate(
                [
                    'flash_deal_id' => $flashDeal->id,
                    'product_variant_id' => $variant->id,
                ],
                [
                    'discount_price' => $discountPrice,
                ]
            );
        }
    } else {
        // Không có biến thể: giả lập biến thể mặc định hoặc tạo mới biến thể mặc định nếu chưa có
        $variant = ProductVariant::firstOrCreate(
            ['product_id' => $product->id],
            [
                'variant_name' => 'Mặc định',
                'variant_price' => $product->price ?? 0,
                'sku' => $product->sku ?? null,
                'stock_quantity' => $product->stock_quantity ?? 0,
            ]
        );

        $discountPrice = round($variant->variant_price * (1 - $request->discount_percent / 100), 2);

        FlashSaleProductVariant::updateOrCreate(
            [
                'flash_deal_id' => $flashDeal->id,
                'product_variant_id' => $variant->id,
            ],
            [
                'discount_price' => $discountPrice,
            ]
        );
    }

    return redirect()->route('admin.flash_deals.index')->with('success', 'Tạo flash deal thành công.');
}


    public function edit($id)
    {
        $flashDeal = FlashDeal::with('flashSaleVariants.productVariant')->findOrFail($id);

        $productId = $flashDeal->flashSaleVariants->first()->productVariant->product_id ?? null;

        $variants = $productId
            ? ProductVariant::with('attributeValues.attribute')
                ->where('product_id', $productId)
                ->get()
            : collect();

        $products = Product::all();

        return view('admin.pages.flash_deals.edit', compact('flashDeal', 'products', 'variants'));
    }

    
public function update(Request $request, $id)
{
    $validated = $this->validateFlashDeal($request);

    $flashDeal = FlashDeal::findOrFail($id);
    $flashDeal->update([
        'title' => $request->title,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'usage_limit' => $request->usage_limit ?? 0,
    ]);

    FlashSaleProductVariant::where('flash_deal_id', $flashDeal->id)->delete();

    $product = Product::find($request->product_id);

    if ($product->variants()->count() > 0) {
        $variants = ProductVariant::whereIn('id', $request->variant_ids ?? [])->get();

        foreach ($variants as $variant) {
            $discountPrice = round($variant->variant_price * (1 - $request->discount_percent / 100), 2);

            FlashSaleProductVariant::updateOrCreate(
                [
                    'flash_deal_id' => $flashDeal->id,
                    'product_variant_id' => $variant->id,
                ],
                [
                    'discount_price' => $discountPrice,
                ]
            );
        }
    } else {
        $variant = ProductVariant::firstOrCreate(
            ['product_id' => $product->id],
            [
                'variant_name' => 'Mặc định',
                'variant_price' => $product->price ?? 0,
                'sku' => $product->sku ?? null,
                'stock_quantity' => $product->stock_quantity ?? 0,
            ]
        );

        $discountPrice = round($variant->variant_price * (1 - $request->discount_percent / 100), 2);

        FlashSaleProductVariant::updateOrCreate(
            [
                'flash_deal_id' => $flashDeal->id,
                'product_variant_id' => $variant->id,
            ],
            [
                'discount_price' => $discountPrice,
            ]
        );
    }

    return redirect()->route('admin.flash_deals.index')->with('success', 'Cập nhật flash deal thành công.');
}

    public function destroy($id)
    {
        $flashDeal = FlashDeal::findOrFail($id);

        FlashSaleProductVariant::where('flash_deal_id', $flashDeal->id)->delete();
        $flashDeal->delete();

        return redirect()->route('admin.flash_deals.index')->with('success', 'Xóa flash deal thành công.');
    }
}
