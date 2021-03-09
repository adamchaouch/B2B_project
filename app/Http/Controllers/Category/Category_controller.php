<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Category_controller extends Controller
{
    //
    public function getCategories()
    {
        $categories = Category::whereNull('parent_category_id')->with('subCategories')->get();
        return response()->json($categories);
    }
    //methed for adding category
    public function addCategory(Request $request)
    {
        //$user = AuthController::me();
        //if ($user->hasRole('Super_Admin')) {
            $category = new Category();
            $category->category_name = $request->input('category_name');
            $category->category_cn = $request->input('category_cn');
            $category->category_it = $request->input('category_it');
            $category->category_fr = $request->input('category_fr');
            $category->parent_category_id = $request->input('parent_category_id');
            if ($request->hasFile('category_image')) {
                $path = $request->file('category_image')->store('categories', 'public');
                $fileUrl = Storage::url($path);
                $category->img_url = $fileUrl;
               // $user->img_name = basename($path);

            }

            if($category->save()) {
                return response()->json("The Category has been added Successfully !!");
            }
        return response()->json("Error !!");
    }
    //to get the parrent category
    public function getCategoryParent($id)
    {
        $subCat = Category::Find($id);
        $parentCat = $subCat->getParentCategory;

        return response()->json($parentCat);
    }
    //to get the child category

    public function getCategoryChild($id)
    {
        $parentCat = Category::find($id);
        $subCat = $parentCat->getChildCategories;
        return response()->json($subCat);
    }


    public function showCategory($id)
    {
        $category = Category::findOrFail($id);
        $category['sub_categories'] = $category->subCategories;
        return response()->json($category);
    }

    public function getMobileCategories()
    {
        $categories = Category::whereNull('parent_category_id')->with('subCategories')->get();
        $categroyList = array();
        $categoryList ['categories'] = $categories;
        return response()->json($categoryList);
    }
    public function deleteCategory($id)
    {
        //$user = AuthController::me();
       // if ($user->hasRole('Super_Admin')) {
            $category = Category::find($id);
            $category->Delete();
            return response()->json(["msg" => "the category has been deleted !!"]);
        //}
    }
    public function updateCategory(Request $request, $id)
    {
       // $user = AuthController::me();
       // if ($user->hasRole('Super_Admin')) {
            $category = Category::findorfail($id);
            $category->category_name = $request->input('category_name');
            $category->category_cn = $request->input('category_cn');
            $category->category_it = $request->input('category_it');
            $category->category_fr = $request->input('category_fr');
            $category->parent_category_id = $request->input('parent_category_id');
            if ($category->save()) {
                return response()->json($category);
            }
            return response()->json(["msg" => "ERROR !!"]);
        }
    //}


//for adding criteria base to category
    public function addCriteria_to_category(Request $request)
    {
        $criterias = $request->input('criteria_ids');
        $category_id = $request->input('category_id');
        $category = category::find($category_id);
        $category->criteriaBase()->attach($criterias);
        return response()->json(
            ["msg"=>'Criteria has been added'],200);
    }
//for delete criteria base from category
    public function deleteCriteria($categ_id,$crit_id)
    {
        $category = category::find($categ_id);
        $category->criteriaBase()->detach($crit_id);
        return response()->json(["msg"=>'Criteria has been deleted'],200);
    }
}
