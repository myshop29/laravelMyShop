<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\models\Shop;

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
                    return response()->json(['success'=>'Shop create successfully.','shop_id' =>$result ]);
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
            $allShops = Shop::where('user_id',$request->user()->id)->get();
            return response()->json(['success'=>'Shop create successfully.','data' => $allShops]);
        } 
        catch(\Illuminate\Database\QueryException $shopsGetDataException)
        {
            if($shopsGetDataException){
                return response()->json($shopsGetDataException);
            }
        }

       // return response()->json($request->user()->id);
    }
}
