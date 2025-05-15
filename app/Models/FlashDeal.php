<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashDeal extends Model
{
    protected $fillable = ['title', 'start_time', 'end_time'];

    public function flashSaleVariants()
    {
        return $this->hasMany(FlashSaleProductVariant::class);
    }

    // Thêm flash sale cho tất cả biến thể của sản phẩm với phần trăm giảm giá
    public function addFlashSaleForProductVariants($product, float $discountPercent)
    {
        foreach ($product->variants as $variant) {
            $discountPrice = round($variant->price * (1 - $discountPercent / 100), 2);

            FlashSaleProductVariant::updateOrCreate(
                [
                    'flash_deal_id' => $this->id,
                    'product_variant_id' => $variant->id,
                ],
                [
                    'discount_price' => $discountPrice,
                ]
            );
        }
    }
}
