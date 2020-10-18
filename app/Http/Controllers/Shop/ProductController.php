<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\Brand;
use App\models\Category;
use App\models\Product;
use App\models\Shop;

class ProductController extends Controller
{
    public function brandWiseCategory(Request $request)
    {
        try{
            $brandWiseCategory = Brand::where('user_id',$request->user()->id)->with('categories')->get();
            return response()->json($brandWiseCategory);
        }
        catch(\Illuminate\Database\QueryException $Exception)
        {
            if($Exception){
                return response()->json(['error'=>$Exception]);
            }
        }
    }

    public function addProduct(Request $request)
    {
        try{
            $product_id = Product::create($request->all());
            return response()->json(['success' => 'Success','product_id' => $product_id]);
        }
        catch(\Illuminate\Database\QueryException $Exception)
        {
            if($Exception){
                return response()->json(['error'=>$Exception]);
            }
        } 
    }

    public function getProducts(Request $request)
    {      
        try{
            $shopId = Shop::where('user_id',$request->user()->id)->value('id');
            $categories = Product::where('shop_id',$shopId)->groupBy('category_id')->select('category_name','category_id')->get();
            try {
                $data=[];
                if(!empty($categories) && isset($categories))
                {
                    foreach ($categories as  $category) {
                        $products = Product::where('category_id',$category->category_id)->with('image')->get();
                    $data[]=['category_name'=>$category->category_name,'products'=> $products];
                    }
                }
                return response()->json($data);
            } catch (\Illuminate\Database\QueryException $Exception) {
               if ($Exception) {
                return response()->json(['error'=>$Exception]);
               }
            }
        }catch(\Illuminate\Database\QueryException $ProductException)
        {
            if($ProductException){
                return response()->json(['error'=>$ProductException]);
            }
        }
    }
}
