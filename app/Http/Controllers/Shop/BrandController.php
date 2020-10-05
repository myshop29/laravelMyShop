<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\Shop;
use App\models\Brand;
class BrandController extends Controller
{
    public function addBrand(Request $request)
    {
        try
        {
            $shopId = Shop::where('user_id',$request->user()->id)->value('id');

            if (!empty($shopId)) 
            {
                 // created on Brand tabels ........
                 try 
                 {
                     $input = $request->all(); 
                     $input['user_id'] = $request->user()->id; 
                     $input['shop_id'] = $shopId; 
                     $result = Brand::create($input)->id;
                     return response()->json(['success'=>'Brand create successfully.']);
                 } 
                 catch(\Illuminate\Database\QueryException $brandTableException)
                 {
                     if($brandTableException){
                         return response()->json($brandTableException);
                     }
                 }  
            } 
        }
        catch(\Illuminate\Database\QueryException $shopsCheckException)
        {
            if($shopsCheckException){
                return response()->json(['error => something wrong please try again.']);
            }
        }
    }

    public function getBrands(Request $request)
    {
        try 
        {
            $skipId = json_decode($request->skip_id);
            $allBrands = Brand::where('user_id',$request->user()->id)->skip($skipId)->take(8)->get();
            return response()->json($allBrands);
        } 
        catch(\Illuminate\Database\QueryException $BrandsGetDataException)
        {
            if($BrandsGetDataException){
                return response()->json($BrandsGetDataException);
            }
        }

       // return response()->json($request->user()->id);
    }

    public function getAllBrands(Request $request)
    {
        try 
        {
            $allBrands = Brand::where('user_id',$request->user()->id)->select('id','brand_name')->get();
            return response()->json($allBrands);
        } 
        catch(\Illuminate\Database\QueryException $BrandsGetDataException)
        {
            if($BrandsGetDataException){
                return response()->json($BrandsGetDataException);
            }
        }
    }
}
