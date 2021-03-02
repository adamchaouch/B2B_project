<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria_unit extends Model
{
    //

    public function CriteriaBase() {
        return $this->belongsTo(Criteria_base::class,'criteria_base_id');
    }

    public function ProductItem() {
        return $this->belongsToMany(
            Product_item::class, 'item_criteria',
            'product_item_id',
            'criteria_id')->withPivot();
    }

}
