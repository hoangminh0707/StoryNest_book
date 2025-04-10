<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'author_id', 'publisher_id'
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
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Mối quan hệ với ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
