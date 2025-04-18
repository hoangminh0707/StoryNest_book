<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content',
        'is_approved',
        'blog_id',
        'name',
        'email',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ polymorphic với các mô hình khác (ví dụ: Post, Product, ...)
    public function commentable()
    {
        return $this->morphTo();
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}

