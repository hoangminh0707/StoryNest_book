<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'value',
    ];

    // Mối quan hệ N-1 với Attribute
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Mối quan hệ N-1 với ProductVariant
    public function productVariants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_variant_attributes',
            'attribute_value_id',
            'product_variant_id'
        );
    }
}
