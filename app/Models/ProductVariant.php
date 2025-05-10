<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_price',
        'stock_quantity',
    ];

    // Mối quan hệ N-1 với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Mối quan hệ 1-N với AttributeValue
    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_attributes', // bảng trung gian
            'product_variant_id',
            'attribute_value_id'
        );
    }


}