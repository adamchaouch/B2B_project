<?php

namespace App\Http\Controllers;
use PragmaRX\Countries\Package\Services\Config;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;


class CountriesControllerTest extends Controller
{
    public function getzonefromcity($city,$nation)
    {
    if (strlen($nation)==2) {
        //$city = "naples";
        $countries = Countries::where('cca2', $nation)->hydrate('cities')->first()->cities->$city->adm1name;
        return response()->json($countries);

    }elseif (strlen($nation)==3){
        $countries = Countries::where('cca3', $nation)->hydrate('cities')->first()->cities->$city->adm1name;
        return response()->json($countries);
    }
    else{
            $countries = Countries::where('name.common', $nation)->hydrate('cities')->first()->cities->$city->adm1name;
            return response()->json($countries);
        }
    }
    public function get_nation($nation){

        $countries= Countries::where('name.common', $nation)->hydrate('cities');

        return response()->json($countries);

    }
    public function getborder_nation_details($nation){

        $countries= Countries::where('name.common', $nation)
            ->hydrate('borders')->first()->borders;
            return response()->json($countries);

    }
    public function get_geo_details_nation($nation){
        $countries = Countries::where('name.common', $nation)->hydrate('geometry')->first()->geo;
        return response()->json($countries);
}
    public function get_alt_long($nation){
        $countries = Countries::where('name.common', $nation)->hydrate('geometry')->first()->geo->latlng;
        return response()->json($countries);
    }

    public function get_alt_long_from_city($city,$nation){
        if (strlen($nation)==2) {
            //$city = "naples";
            $countries = Countries::where('cca2', $nation)->hydrate('cities')->first()->cities->$city;
            return response()->json(["latitude" => $countries->latitude,"longitude"=>$countries->longitude]
            );

        }elseif (strlen($nation)==3){
            $countries = Countries::where('cca3', $nation)->hydrate('cities')->first()->cities->$city->adm1name;
            return response()->json($countries);
        }
        else{
            $countries = Countries::where('name.common', $nation)->hydrate('cities')->first()->cities->$city->adm1name;
            return response()->json($countries);
        }

    }
    public function getborder(){

        $countries= Countries::all()->pluck('name.common');
        return response()->json($countries);



    }
}
