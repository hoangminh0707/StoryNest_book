<?php

namespace App\Models\address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    
    public function districts() {
        return $this->hasMany(District::class);
    }
    
}
