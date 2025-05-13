<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'is_approved',
    ];

    // Quan hệ với User

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    // Truy vấn các review đã được duyệt
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Truy vấn các review chưa duyệt
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}