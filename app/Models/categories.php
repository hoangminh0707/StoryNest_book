<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'parent_id'];

    // Quan hệ: 1 danh mục có thể có nhiều danh mục con
    public function children()
    {
        return $this->hasMany(categories::class, 'parent_id');
    }

    // nếu cần đệ quy sâu nhiều cấp:
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
    // Quan hệ: 1 danh mục có thể thuộc danh mục cha
    public function parent()
    {
        return $this->belongsTo(categories::class, 'parent_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }


    public function voucherConditions()
    {
        return $this->hasMany(VoucherCondition::class, 'category_id');
    }
}
