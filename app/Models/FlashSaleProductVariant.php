<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSaleProductVariant extends Model
{
    protected $fillable = ['flash_deal_id', 'product_variant_id', 'discount_price'];

    public function flashDeal()
    {
        return $this->belongsTo(FlashDeal::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
