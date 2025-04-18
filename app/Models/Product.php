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
        'price',
        'category_id',
        'author_id',
        'publisher_id',
        'product_type',
        'status',
    ];

    // Mối quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
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
}