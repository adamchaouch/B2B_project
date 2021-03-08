<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_base extends Model

{
    protected $guarded = [];

    // Relationships
     public function category() {
        return $this->belongsTo(category::class, 'category_id');
    }

    public function Brand() {
        return $this->belongsTo(Product_brand::class, 'brand_id');
    }

    public function items() {
        return $this->hasMany(Product_item::class, 'product_base_id');
    }
    public function supplier() {
        return $this->belongsTo(User::class, 'supplier_id');
    }
}
