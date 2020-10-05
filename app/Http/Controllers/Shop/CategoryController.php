<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\Shop;
use App\models\Brand;
use App\models\Category;
class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        try
        {
            $lastCategoryId = Category::create($request->all())->id;
            return response()->json(['success' => 'Category create successfully','data' => $lastCategoryId]);
        }
        catch(\Illuminate\Database\QueryException $categoryCheckException)
        {
            if($categoryCheckException){
                return response()->json(['error => something wrong please try again.']);
            }
        }
    }

    public function getCategories(Request $request)
    {
        try 
        {
            $skipId = json_decode($request->skip_id);
            $allbrandId = Brand::where('user_id',$request->user()->id)->get()->pluck('id');
            $categories = Category::whereIn('brand_id',$allbrandId)->skip($skipId)->take(8)->get();
            return response()->json(['success' => 'Success' , 'categories'=>$categories]);
        } 
        catch(\Illuminate\Database\QueryException $CategoryGetDataException)
        {
            if($CategoryGetDataException){
                return response()->json($CategoryGetDataException);
            }
        }
    }
}
