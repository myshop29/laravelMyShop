<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\models\Brand;
use App\models\Category;
use App\models\Product;
use App\models\Shop;
use App\models\Seller;
use App\models\Worker;

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
            $shopId = '';
            $shopId = Shop::where('user_id',$request->user()->id)->value('id');
            if (empty($shopId)) {
                $shopId = Seller::where('user_id',$request->user()->id)->value('shop_id');
            }
            if (empty($shopId)) {
                $shopId = Worker::where('user_id',$request->user()->id)->value('shop_id');
            }

            $categories = Product::where('shop_id',$shopId)->groupBy('category_name')->select('category_name','category_id')->get();
            try {
                $data=[];
                if(!empty($categories) && isset($categories))
                {
                    foreach ($categories as  $category) {
                        $categories = Category::where('category_name',$category->category_name)->pluck('id');
                        $totalAmount = Product::whereIn('category_id',$categories)->sum(DB::raw('selling_price * qty'));
                        $products = Product::whereIn('category_id',$categories)->with('image')->get();
                        $data[]=['category_name'=>$category->category_name,'total_amount' => $totalAmount ,'products'=> $products];
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
