<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'rating', 'review', 'is_approved'
    ];

    // Quan hệ với bảng User (người dùng đã đánh giá)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng Product (sản phẩm được đánh giá)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
