<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_brand extends Model
{
    // Relationships
    public function Products() {
        return $this->hasMany(Product_base::class, 'brand_id');
    }
}
