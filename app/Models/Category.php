<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function productBase() {
        return $this->hasMany(Product_base::class);
    }

    public function getParentCategory() {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function getChildCategories() {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function subCategories() {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function CriteriaBase() {
        return $this->belongsToMany(
            Criteria_base::class,
            'categories_criteria',
            'category_id',
            'criteria_id');
    }
}
