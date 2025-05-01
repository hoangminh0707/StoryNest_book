<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'author_id',
        'publisher_id',
        'status',
        'product_type',
        'price',
        'quantity'
    ];

    // Mối quan hệ với Category
    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'category_product', 'product_id', 'category_id');
    }
    // Mối quan hệ với Author
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    // Mối quan hệ với Publisher
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    // Mối quan hệ với ProductImage
    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->where('is_thumbnail', true);
    }

    // Mối quan hệ với ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
    }
    public function voucherConditions()
    {
        return $this->hasMany(VoucherCondition::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    //


    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }



    public function productAttributes()
    {
        // bảng trung gian product_attribute
        return $this->hasMany(ProductAttribute::class);
    }



    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'voucher_conditions', 'product_id', 'voucher_id')
            ->where('condition_type', 'product');
    }



}