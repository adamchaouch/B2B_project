<?php

namespace App\Http\Controllers\Criteria_base;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Criteria_base;
use App\Models\Criteria_unit;
use Illuminate\Http\Request;

class Criteria_base_controller extends Controller
{
    //

    public function addCriteria(Request $request)
    {
        $criteria = $request->input('criteria_name');
        $criteriaUnits = $request->input('units');

        $criteriaBase = new Criteria_base();
        $criteriaBase->name = $criteria;
        $criteriaBase->save();
        if ($request->filled('categories_id')) {
            $categories_id = $request->input('categories_id');
            foreach ($categories_id as $category_id) {
                $category = category::find($category_id);
                $criteriaBase->Categories()->attach($category);
            }
        }
        if (!empty($criteriaUnits)) {
            foreach ($criteriaUnits as $unit) {
                $criteriaUnit = new Criteria_unit();
                $criteriaUnit->unit_name = $unit;
                $criteriaUnit->criteria_base_id = $criteriaBase->id;
                $criteriaUnit->save();
            }
        }

        return response()->json(['msg' => 'criteria base has been saved'], 200);
    }
    public function getCriteriaList(Request $request)
    {
        if ($request->filled('category_id')) {
            $category_id = $request->input('category_id');
            $criteriaList = Category::with(['CriteriaBase' => function ($query) {
                $query->with('CriteriaUnit')->get();
                $query->with('productItems:criteria_unit_id,criteria_value')->get();
            }])->find($category_id);
        } else {
            $criteriaList = Criteria_base::with('CriteriaUnit','Categories')->get();
        }
        return response()->json($criteriaList, 200);
    }
    public function getCriteria(Request $request)
    {
        $criteria_id = $request->input('criteria_id');
        $criteriaList = Criteria_base::with('CriteriaUnit','Categories')->find($criteria_id);

        return response()->json($criteriaList,200);
    }
    public function deleteCriteria(Request $request, $id)
    {
        // $criteria_id = $request->input('criteria_id');
        $criteria = Criteria_base::find($id);
        $criteria->Categories()->detach();
        $criteria->CriteriaUnit()->delete();
        // $criteria->CriteriaUnit()->detach();
        if ($criteria->delete()) {
            return response()->json(['msg' => 'Success'], 200);
        }
        return response()->json(['msg' => 'Error'], 500);
    }
    public function updateCriteria(Request $request, $id)
    {
        $criteria_name = $request->input('criteria_name');
        $criteriaUnits = $request->input('units');
        // $Unit_ids = $request->input('Units_id');
        $categories_id = $request->input('categories_id');
        $criteriaBase = Criteria_base::find($id);
        $criteriaBase->name = $criteria_name;

        $criteriaBase->save();
        if (!empty($categories_id)) {
            $criteriaBase->Categories()->sync($categories_id);
        }
        // if (!empty($Unit_ids)) {
        //     $criteriaBase->CriteriaUnit()->sync($Unit_ids);
        // }
        if (!empty($criteriaUnits)) {
            foreach ($criteriaUnits as $units) {
                $unit = (object) $units;
                $criteriaUnit = Criteria_unit::find($unit->id);
                $criteriaUnit->unit_name = $unit->unit_name;
                $criteriaUnit->save();
            }
        }
        return response()->json(['msg' => 'criteria base has been saved'], 200);
    }
}
