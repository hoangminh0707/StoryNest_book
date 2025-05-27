<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Blog extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'title',
        'image_url',
        'content',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Blog.php
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->where('is_approved', true);
    }



}
