<?php

namespace App\Models\address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public function wards() {
        return $this->hasMany(Ward::class);
    }
    
    public function province() {
        return $this->belongsTo(Province::class);
    }
    
}
