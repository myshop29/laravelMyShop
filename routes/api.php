<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();

// });

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('register', 'Auth\AuthController@register');
    
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Auth\AuthController@logout');
       // Route::post('user', 'Auth\AuthController@user');
        Route::get('user2', 'Auth\AuthController@user2');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('add-distributor', 'Distributor\DistributorController@addDistributor');
        Route::post('get-distributors', 'Distributor\DistributorController@getDistributors');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('add-retailer', 'Retailer\RetailerController@addRetailer');
        Route::post('get-retailers', 'Retailer\RetailerController@getRetailers');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('add-seller', 'Seller\SellerController@addSeller');
        Route::post('get-sellers', 'Seller\SellerController@getSellers');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('add-worker', 'Worker\WorkerController@addWorker');
        Route::post('get-workers', 'Worker\WorkerController@getWorkers');
    });

    
    Route::group(['middleware' => 'auth:api'], function() {
        //Shop
        Route::post('add-shop', 'Shop\ShopController@addShop');
        Route::get('get-shops', 'Shop\ShopController@getShops');
        //Brands   
        Route::post('add-brand', 'Shop\BrandController@addBrand');
        Route::get('get-all-brands', 'Shop\BrandController@getAllBrands');
        Route::post('get-brands', 'Shop\BrandController@getBrands');
        //Category
        Route::post('add-category', 'Shop\CategoryController@addCategory');
        Route::post('get-categories', 'Shop\CategoryController@getCategories');
        //Product 
        Route::post('upload-take-photo', 'Shop\ImageController@uploadTakePhoto');
        Route::get('brand-wise-category', 'Shop\ProductController@brandWiseCategory');
        Route::get('get-products', 'Shop\ProductController@getProducts');
        Route::post('add-product', 'Shop\ProductController@addProduct');
        Route::post('selling-product', 'Shop\SellController@addSelling');
    });
});



