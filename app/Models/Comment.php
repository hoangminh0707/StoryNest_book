<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'content',
        'is_approved',
        'parent_id',
    ];

    // Quan hệ với người dùng (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với các bình luận trả lời (replies)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Quan hệ với bình luận cha (parent comment)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Quan hệ polymorphic với sản phẩm và bài viết (Blog)
    public function commentable()
    {
        return $this->morphTo();
    }
}
