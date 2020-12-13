<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\Shop;
use App\models\Seller;
use App\models\Worker;

class ShopController extends Controller
{
    public function addShop(Request $request)
    {
        try
        {
            $result = Shop::where('user_id',$request->user()->id)->value('id');
            if (!empty($result)) 
            {
                return response()->json(['warning'=>'Your already have a shop .']);
            } 
            else 
            {
                // created on Shop tabels ........
                try 
                {
                    $input = $request->all(); 
                    $input['user_id'] = $request->user()->id; 
                    $input['status'] = 'Active'; 
                    $result = Shop::create($input)->id;
                    try {
                        $allShops = Shop::where('user_id',$request->user()->id)->get();
                        return response()->json(['success'=>'Shop create successfully.','data' =>$allShops ]);
                    } catch (\Illuminate\Database\QueryException $getShopEx) {
                        if($shopsTableException){
                            return response()->json($getShopEx);
                        }
                    }

                } 
                catch(\Illuminate\Database\QueryException $shopsTableException)
                {
                    if($shopsTableException){
                        return response()->json($shopsTableException);
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

    public function getShops(Request $request)
    {
        try 
        {
            $allShops = [];
            $allShops = Shop::where('user_id',$request->user()->id)->get();
            if (count($allShops)>0) {
                return response()->json(['success'=>'All Shops.','data' => $allShops]);
            }
            else{
                $sellerParentId = Seller::where('user_id',$request->user()->id)->pluck('parent_id');
                $allShops = Shop::whereIn('user_id',$sellerParentId)->get();
                if (count($allShops)>0) {
                    return response()->json(['success'=>'All Shops.','data' => $allShops]);
                }
                else{
                    $workerParentId = Worker::where('user_id',$request->user()->id)->pluck('parent_id');
                    $allShops = Shop::whereIn('user_id',$workerParentId)->get();
                    if (count($allShops)>0) {
                        return response()->json(['success'=>'All Shops.','data' => $allShops]);
                    }
                    else{
                        return response()->json(['success'=>'All Shops.','data' => $allShops]);
                    }
                }
            }
        } 
        catch(\Illuminate\Database\QueryException $shopsGetDataException)
        {
            if($shopsGetDataException){
                return response()->json($shopsGetDataException);
            }
        }
    }
}
