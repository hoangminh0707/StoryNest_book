<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'content', 'status'];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


}
