<?php

namespace App\Http\Controllers\CatalogImagesController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Models\product_Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogImagesController extends Controller
{
    public function get_images_by_user(){
        $supplier = AuthController::me();
        $Images=product_Images::all()->where('user_id',$supplier->id)->orWhere('user_id',null);
        return response()->json($Images);
    }

    public function delete_images($id){
        $Image=product_Images::find(id);
        $Image->user()->detach();
      if ( $Image->delete()){
          return response()->json(["msg" => "images has been deleted"], 200);
      }
        return response()->json(["msg" => "Error"], 500);

    }

    public function deleteImage($id)
    {
        $image = product_Images::find($id);
        $isImageDeleted = Storage::disk('public')->delete('products/' . $image->image_name);
        if ($isImageDeleted) {
            $image->delete();
            return response()->json(['msg' => 'Image Deleted'], 200);
        }
        return response()->json(['msg' => 'Error'], 500);
    }


    public function uploadImages(Request $request)
    {
        if ($request->hasFile('file')) {
            // $supplier = AuthController::me();
            $path = $request->file('file')->store('products', 'public');
            $fileUrl = Storage::url($path);
            $image = new product_Images();
            $image->image_url = $fileUrl;
            $image->image_name = basename($path);
            //$image->user_id=$supplier_id;
            $image->save();
            return response()->json(["id" => $image->id, "image_url" => $fileUrl], 200);
        }
        return response()->json(['msg' => 'Error'], 500);
    }


}
