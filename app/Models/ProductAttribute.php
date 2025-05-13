<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attribute'; // Chỉ định bảng

    // Không cần khai báo $fillable nếu bạn không muốn thay đổi bảng này qua Eloquent
    protected $fillable = ['product_id', 'attribute_id'];

    public function product()
    {
        return $this->belongsTo(Product::class); // Mỗi bản ghi product_attribute thuộc về một sản phẩm
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class); // Mỗi bản ghi product_attribute thuộc về một thuộc tính
    }
}
