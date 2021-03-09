<?php

namespace App\Http\Controllers\User_group;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\group;
use App\Models\User;
use Illuminate\Http\Request;

class user_group_controller extends Controller
{
    public function get_users_by_group(){
        $user_cat = User::with('user_group_categories')->get();
        return response()->json(["msg" => "Sucess",
            "data"=>$user_cat], 500);


    }

    public function get_catego_of_users(){
        $user_cat = Category::with('user_group_categories')->get();
        return response()->json(["msg" => "Sucess",
            "data"=>$user_cat], 500);


    }

    public function addgroup(Request $request){

        $group= new group();
        $group->name=$request->input('name');
        $group->description=$request->input('description');

       if($group->save()) {
           return response()->json(["msg" => "group addedwith sucess !"]);
       }
        return response()->json(["msg" => "error to save "]);
    }

    public function get_group_list(){
        $group=group::all()->get();
        return response()->json(["msg" => "sucess !",
            "data"=>$group]);

    }
    public function get_group_by_id($id){
        $group=group::find($id);
        if($group){ return response()->json(["msg" => "sucess !",
            "data"=>$group]);}
        return response()->json(["msg" => "group notfound  !",
            ]);

    }

    public function delete_group(Request $request,$id){
        $group=group::find($id);
        if($group->delete()){ return response()->json(["msg" => "deleted !",
            "data"=>$group]);}
        return response()->json(["msg" => "group notfound  !",
        ]);

    }
}
