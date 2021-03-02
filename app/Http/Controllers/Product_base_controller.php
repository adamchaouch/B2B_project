<?php

namespace App\Http\Controllers;
use App\Models\Criteria_base;
use App\Models\product_Images;
use App\Models\Product_item;
use Illuminate\Support\Facades\Response;

use App\Models\Product_base;
use Illuminate\Http\Request;

class Product_base_controller extends Controller
{

    //store product
    public function store_product_base(Request $request)
    {
        $this->validate($request, [
            "product_name"=> "required",
            "product_description"=> "required",
        ]);

        $newAddedproduct= new Product_base();
        $newAddedproduct->product_name = $request->input('product_name');
        $newAddedproduct->product_description = $request->input('product_description');
        $newAddedproduct->taxe_rate = $request->input('taxe_rate');
        $newAddedproduct->supplier_id = $request->input('supplier_id');
        $newAddedproduct->category_id = $request->input('category_id');
        $newAddedproduct->brand_id = $request->input('brand_id');
        $newAddedproduct->product_image_url = $request->input('product_image_url');
        //adding product item to product base
        $product_items = $request->input('items');

        if($newAddedproduct->save()){

            //foreach product item in productbase

            foreach ($product_items AS $items){
                $item = (object) $items;
                $product_item = new Product_item();
                $product_item->item_offline_price = isset($item->item_offline_price) ? $item->item_offline_price : null;
                $product_item->item_online_price = isset($item->item_online_price) ? $item->item_online_price : null;
                $product_item->item_package = isset($item->item_package) ? $item->item_package : 1;
                $product_item->item_box = isset($item->item_box) ? $item->item_box : 1;
                $product_item->item_barcode = $item->item_barcode;
                $product_item->item_quantity = $item->item_quantity;
                $product_item->item_warn_quantity = isset($item->item_warn_quantity) ? $item->item_warn_quantity : null;
                $product_item->product_base_id = $newAddedproduct->id;
                $criteria_list = $item->criteria_list;
                $item_images = $item->image_list;

                if ($product_item->save()) {
                    foreach ($criteria_list as $criteriaItems) {
                        $criteriaItem = (object) $criteriaItems;
                        $criteria = Criteria_base::find($criteriaItem->criteria_id);
                        $product_item->CriteriaBase()
                            ->attach($criteria, ["criteria_value" => $criteriaItem->criteria_value,
                                "criteria_unit_id" => $criteriaItem->criteria_unit_id]);
                    }

                    foreach ($item_images as $key => $image_id) {
                        $item_image = product_Images::find($image_id);
                        $item_image->product_item_id = $product_item->id;
                        $item_image->save();
                    }

                }

            }
            return Response::json(
            ["message"=> "Product_base created successfully"],
            201
        );
    }
        return response()->json(["msg" => "Error"], 404);

    }

    public function updateProductBase(Request $request, $id)
    {
        $product_base = Product_base::find($id);
        $product_base->product_name =  $request->input('product_name');
        $product_base->product_description = $request->input('product_description');
        $product_base->taxe_rate = $request->input('taxe_rate');
        $product_base->category_id = $request->input('category_id');
        $product_base->brand_id = $request->input('brand_id');
        $product_base->product_image_url = $request->input('img_url');
        $product_base->save();
        return response()->json(['msg'=>"product base has been updated !!"],200);
    }

    public function show_by_id($id)
    {

        $product_base = Product_base::find($id);
         if(isset($product_base)){
         return response()->json(['msg'=>"succes",
                         "data"=>$product_base],
             200);}
         else{
             return response()->json(['msg'=>"product not found",
             ],
             200);}}


    public function deleteProductBase(Request $request, $product_id)
    {
        // $product_base_id = $request->input('product_id');
        $product = Product_base::with('items')->find($product_id);
        foreach ($product->items as $item)
        {
           $item->Images()->delete();
            $item->CriteriaBase()->detach();
        }
        $product->items()->delete();
        //->wish_list()->detach();
        if ($product->delete()) {
            return response()->json(["msg" => "Product has been deleted"], 200);
        }
        return response()->json(["msg" => "Error"], 500);


    }

    public function updateProductWithItem(Request $request)
    {
        //$supplier = AuthController::me();
        $product_base_id = $request->input('product_base_id');
        $product_base = Product_base::find($product_base_id);
        $product_base->product_name = $request->input('product_name');
        $product_base->product_description = $request->input('product_description');
        $product_base->taxe_rate = $request->input('taxe_rate');
        // $product_base->supplier_id = $supplier->id;
         $product_base->category_id = $request->input('category_id');
        $product_base->brand_id = $request->input('brand_id');
        $product_items = $request->input('product_items');
        if ($product_base->save()) {


                $sync_array = array();
                $item = (object) $product_items;

                $product_item = Product_item::find($item->item_id);
                $product_item->item_offline_price = isset($item->item_offline_price) ? $item->item_offline_price : null;
                $product_item->item_online_price = isset($item->item_online_price) ? $item->item_online_price : null;
                $product_item->item_package = isset($item->item_package) ? $item->item_package : 1;
                $product_item->item_box = isset($item->item_box) ? $item->item_box : 1;
                $product_item->item_barcode = $item->item_barcode;
                $product_item->item_quantity = $item->item_quantity;
                $product_item->item_warn_quantity = isset($item->item_warn_quantity) ? $item->item_warn_quantity : null;
                $product_item->item_discount_type = isset($item->item_discount_type) ? $item->item_discount_type : null;
                $product_item->item_discount_price = isset($item->item_discount_price) ? $item->item_discount_price : null;
                $product_item->product_base_id = $product_base->id;
                $criteria_list = $item->criteria_list;
               // $item_images = $item->image_list;
                if ($product_item->save()) {

                    foreach ($criteria_list as $criteriaItems) {
                        $criteriaItem = (object) $criteriaItems;
                        $sync_array[$criteriaItem->criteria_id] = ["criteria_value" => $criteriaItem->criteria_value,
                            "criteria_unit_id" => $criteriaItem->criteria_unit_id ] ;
                    }
                    $product_item->CriteriaBase()->sync($sync_array);
                }
                else {
                    return response()->json(["msg" => "Error while saving"], 404);
                }


            return response()->json(["msg" => "Product updated Succeffully "], 200);
        }
        else {
            return response()->json(["msg" => "Error while saving"], 404);
        }
    }

    public function getProductList(Request $request)
    {
       // $supplier = AuthController::me();
        $barcode = $request->input('barcode');
        $keyWord = $request->input('keyword');
        $category = $request->input('category_id');
        $brand = $request->input('brand_id');
        $productList= Product_base::with(['brand','category','items'=>function ($query) use ($barcode)
        {$query->with('CriteriaBase','images')
            ->when($barcode != '', function ($q) use ($barcode)
            {$q->where('item_barcode',$barcode);})
            ->get();}])
            ->when($barcode != '', function ($q) use ($barcode){
                $q->whereHas('items',function ($q) use ($barcode)
                {$q->where('item_barcode',$barcode);});})
            ->when($keyWord != '', function ($q) use ($keyWord)
            {   $q->where('product_name', 'like', '%' . $keyWord . '%')->get();
            })
            ->when($category != '', function ($q) use ($category)
            {   $q->where('category_id', $category)->get();
            })
            ->when($brand != '', function ($q) use ($brand)
            {   $q->where('brand_id', $brand)->get();
            })
           // ->where('supplier_id',$supplier->id)
            ->orderBy('id','desc')
            ->paginate(50);

        return response()->json($productList, 200);
    }

    public function getProduct(Request $request,$product_id)
    {
       // $supplier = AuthController::me();
       // $product_id = $request->input('product_id');
        $product= Product_base::with(['brand','category',/*'supplier'*/])
            ->where('id',$product_id)->first();
        $items = Product_item::with('images','CriteriaBase')
            ->with(['product' => function ($q) {
               // $q->with('supplier')->get();
            }])
            ->where('product_base_id',$product_id)->get();
        foreach ($items as $key => $item) {
            $item->product_base_name = $product->product_name;
            $item->supplier_id = $product->supplier_id;
        }
        $product->items = $items;
        return response()->json($product, 200);
    }





}
