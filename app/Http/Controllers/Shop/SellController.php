<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\Product;
use App\models\Shop;
use App\models\Sell;
use App\models\Sell_tranjection;

class SellController extends Controller
{
    public function addSelling(Request $request)
    {
        try{
            $sellingData = array('user_id'=> $request->user()->id , 'total_amount' => json_decode($request->total_amount) , 'total_selling_price' =>$request->total_selling_price);
            $sellId = Sell::create($sellingData)->id;
            if ($sellId) {
               try {
                    $sellTranjection = json_decode($request->sell_products);
                    for ($i=0; $i <count($sellTranjection); $i++) { 
                        $sellData[]= array('sell_id' => $sellId,'shop_id' => $sellTranjection[$i]->shop_id,
                        'brand_id' => $sellTranjection[$i]->brand_id,'category_id' => $sellTranjection[$i]->category_id,
                        'image_id' => $sellTranjection[$i]->image_id,'brand_name'=> $sellTranjection[$i]->brand_name,
                        'category_name'=> $sellTranjection[$i]->category_name,'product_name'=> $sellTranjection[$i]->product_name,
                        'product_type'=> $sellTranjection[$i]->product_type,'purchase_price'=> $sellTranjection[$i]->purchase_price,
                        'selling_price'=> $sellTranjection[$i]->selling_price,'disc_sell_price' => $sellTranjection[$i]->disc_sell_price,
                        'qty'=> 1);
                        $productId = $sellTranjection[$i]->id;
                        $productUpdateArr=[
                            'qty' => $sellTranjection[$i]->qty - 1 , 
                            'total_pur_price' => $sellTranjection[$i]->total_pur_price - $sellTranjection[$i]->purchase_price * 1
                        ]; 
                       
                        Product::where('id',$sellTranjection[$i]->id)->update($productUpdateArr);
                    }
                    try {
                        $result = Sell_tranjection::insert($sellData); 
                        return response()->json(['success' => 'Success']);
                    } catch (\Illuminate\Database\QueryException $SellTranjectionExec) {
                        if($SellTranjectionExec){
                            $Deletedid = Sell::where('id',$sellId)->delete();
                            return response()->json(['error'=>$SellTranjectionExec]);
                        }
                    }
               } catch (\Illuminate\Database\QueryException $updateProductExe) {
                    if($updateProductExe){
                        $Deletedid = Sell::where('id',$sellId)->delete();
                        return response()->json(['error'=>$updateProductExe]);
                    }
               }
            }
            
            return response()->json(['error'=> 'Something wrong , please try again .']);
        }
        catch(\Illuminate\Database\QueryException $Exception)
        {
            if($Exception){
                return response()->json(['error'=>$Exception]);
            }
        }
    }
}
