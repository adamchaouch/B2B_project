<?php

namespace App\Http\Controllers\criteria_unit_controller;

use App\Http\Controllers\Controller;
use App\Models\Criteria_unit;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

class criteria_unit_controller extends Controller
{
    //for adding criteria unit and atach to criteria base
    public function addCriteriaUnit(Request $request)
    {
        $criteria_id = $request->input('criteria_id');
        $criteriaUnits = $request->input('units');

        foreach($criteriaUnits as $unit)
        {
            $unit=(Object)$unit;
            $criteriaUnit = new Criteria_unit() ;
            $criteriaUnit->unit_name = $unit->unit_name;
            $criteriaUnit->criteria_base_id = $criteria_id;
            $criteriaUnit->save();
        }
        return response()->json(['msg'=>'criteria unit has been saved'],200);
    }

    public function updateUnit(Request $request, $id)
    {
        $unit_name = $request->input('unit_name');
        $criteriaUnit = Criteria_unit::find($id);
        $criteriaUnit->unit_name = $unit_name;
        if($criteriaUnit->save()){
            return response()->json(['msg'=>'criteria unit has been saved'],200);
        }

        return response()->json(['msg'=>'Error'],500);

    }

    public function deleteUnit(Request $request, $id)
    {
        $criteria_unit = Criteria_unit::find($id);
        if ($criteria_unit->delete()) {
            return response()->json(['msg'=>'Success'],200);
        }
        return response()->json(['msg'=>'Error!!'],500);
    }


    public function getUnit($id)
    {
        //$unit_id = $request->input('unit_id');
        $criteria_unit = Criteria_unit::find($id);
        return response()->json($criteria_unit,200);
    }
}
