<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['addSupplier', 'addShop_Owner', 'addSalesManager','signUp','signUpShop','createUsers','getRoles','updateShopOwner']]);
    }

    public function createUsers (Request $request){

        $tmp =User::where('email',$request->input('email'))->count();//->orWhere('contact',$request->input('contact'))->first();
        if($tmp) {
            return response()->json(["msg" => "User already exists !!",
                "data"=>$tmp]);
        }

        if($request->input('role_id') == 3) {
            return response()->json(["msg" => "shopowner"]);//$this->signUpShop($request);
        } else {
            $password = $request->input('password');
            $user = new User();
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');
            $user->description = $request->input('description');
            $user->password = Hash::make($password);
            $user->phone_num1 =$request->input('phone_num1');
            $user->phone_num2 = $request->input('phone_num2');
            $min_price =$request->has('min_price')? $request->input('min_price'):0;
            $logistic_service =$request->has('logistic_service')? $request->input('logistic_service'):0;
            $user->tax_number =$request->input('tax_number');
            $user->first_resp_name = $request->input('first_resp_name');
            $user->adress = $request->input('adress');
            $user->country =$request->input('country');
            $user->region = $request->input('region');
            $user->postal_code =$request->input('postal_code');
            $user->longitude = $request->input('lng');
            $user->latitude = $request->input('lat');
            $user->min_price =$min_price ;
            $user->logistic_service = $logistic_service;
            $user->product_visibility = $request->input('product_visibility');
            if ($request->hasFile('profil_img')) {
                $path = $request->file('profil_img')->store('profils','public');
                $fileUrl = Storage::url($path);
                $user->img_url = $fileUrl;
                $user->img_name = basename($path);
            }
            $role = Role::where('id', $request->role_id)->first();

            $role->users()->save($user);

            return response()->json(["msg" => "user added successfully with role " .$role->name ], 200);
        }


    }
    public static function getUserByEmail($email)
    {
        return User::whereEmail($email)
            ->with('role')->first();
    }
}
