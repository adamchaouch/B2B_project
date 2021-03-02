<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Controllers\Product_base_controller;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Routes for product_base Managment
$router->post('/product_base','Product_base_controller@store_product_base');
$router->get('/product_base/{id}','Product_base_controller@show_by_id');
$router->put('/product_base/{id}','Product_base_controller@updateProductBase');
$router->put('/product_upadate/','Product_base_controller@updateProductWithItem');
$router->delete('/deleteProd/{id}', 'Product_base_controller@deleteProductBase');
//notyet
$router->get('/product_baselist/', 'Product_base_controller@getProductList');
$router->get('/product_baselist/{product_id}', 'Product_base_controller@getProduct');



//Routes for product_item Managment
$router->post('/product_item/','Product_item_controller\Product_item_controller@addItem');
$router->post('/product_item_criteria/','Product_item_controller\Product_item_controller@addItemCriteria');
$router->put('/updateItemCriteria/','Product_item_controller\Product_item_controller@updateItemCriteria');
$router->delete('/deleteItem/{item_id}','Product_item_controller\Product_item_controller@deleteItem');
$router->delete('/deleteItemCriteria/','Product_item_controller\Product_item_controller@deleteItemCriteria');
$router->get('/product_item/{item_id}','Product_item_controller\Product_item_controller@getItem');
$router->get('/product_itemlist/{product_id}','Product_item_controller\Product_item_controller@getProductItemList');
$router->get('/generate/item/barcode/','Product_item_controller\Product_item_controller@generateBarcode');
///****images managment
$router->post('/image/','Product_item_controller\Product_item_controller@uploadImages');
$router->delete('/image/{id}','Product_item_controller\Product_item_controller@deleteImage');




//Routes for Category Managment
$router->post('/category','Category\Category_controller@addCategory');
$router->get('/category','Category\Category_controller@getCategories');
$router->get('/categorychild/{id}','Category\Category_controller@getCategoryChild');
$router->get('/categoryparent/{id}','Category\Category_controller@getCategoryParent');
$router->get('/showcategory/{id}','Category\Category_controller@showCategory');
$router->delete('/category/{id}','Category\Category_controller@deleteCategory');
$router->put('/category/{id}','Category\Category_controller@updateCategory');
////Routes for criteria category Managment
$router->post('/category_criteria/','Category\Category_controller@addCriteria_to_category');
$router->delete('/category_criteria/{categ_id}/{crit_id}','Category\Category_controller@deleteCriteria');

////Routes for criteria  Managment
$router->post('/criteria/','Criteria_base\Criteria_base_controller@addCriteria');
$router->get('/criterialist/','Criteria_base\Criteria_base_controller@getCriteriaList');
$router->get('/criteria/','Criteria_base\Criteria_base_controller@getCriteria');
$router->delete('/criteria/{id}','Criteria_base\Criteria_base_controller@deleteCriteria');
$router->put('/criteria/{id}','Criteria_base\Criteria_base_controller@updateCriteria');

////Routes for criteria unit  Managment
$router->post('/criteriaunit/','criteria_unit_controller\criteria_unit_controller@addCriteriaUnit');
$router->put('/criteriaunit/{id}','criteria_unit_controller\criteria_unit_controller@updateUnit');
$router->delete('/criteriaunit/{id}','criteria_unit_controller\criteria_unit_controller@deleteUnit');
$router->get('/criteriaunit/{id}','criteria_unit_controller\criteria_unit_controller@getUnit');

////Routes for Brand  Managment
$router->post('/brandadd/','Brand_controller\Brand_controller@addBrand');
$router->get('/brand/','Brand_controller\Brand_controller@getBrandList');
$router->get('/brandmobile/','Brand_controller\Brand_controller@getMobileBrandList');
$router->get('/brand/{id}','Brand_controller\Brand_controller@getBrand');
$router->post('/brandup/','Brand_controller\Brand_controller@updateBrand');
$router->delete('/brand/','Brand_controller\Brand_controller@deleteBrand');




















