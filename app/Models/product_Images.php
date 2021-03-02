<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_Images extends Model
{
    protected $table ='product_images';

    public static $rules = [
        // Validation rules
    ];

    // Relationships

    public function Item() {
        return $this->belongsTo(Product_item::class, 'product_item_id');
    }
}
