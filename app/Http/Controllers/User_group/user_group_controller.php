<?php

namespace App\Http\Controllers\User_group;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function add_category_to_user(){

    }
}
