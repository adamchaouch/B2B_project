<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_item extends Model
{
    // Relationships
    public function Product() {
        return $this->belongsTo(Product_base::class, 'product_base_id');
    }
    public function Images() {
        return $this->hasMany(product_Images::class, 'product_item_id');
    }
    public function CriteriaBase() {
        return $this->belongsToMany(
            Criteria_base::class,
            'items_criteria',
            'product_item_id',
            'criteria_id')
                    ->withPivot(['criteria_value', 'criteria_unit_id'])
                    ->withTimestamps()->orderby('criteria_id','asc');
    }
}
