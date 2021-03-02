<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criteria_base extends Model
{
    //relation ships

    public function Categories()
    {
        return  $this->belongsToMany(Category::class, 'categories_criteria', 'criteria_id', 'category_id');
    }

    public function CriteriaUnit()
    {
        return  $this->hasMany(Criteria_unit::class);
    }

}
