<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id'];

    // Quan hệ: 1 danh mục có thể có nhiều danh mục con
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Quan hệ: 1 danh mục có thể thuộc danh mục cha
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

}

