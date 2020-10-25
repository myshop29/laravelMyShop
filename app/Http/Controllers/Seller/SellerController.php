<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Setting;
use App\models\Seller;
use App\models\Shop;
class SellerController extends Controller
{
    // user and Seller tabels are create data with try catch block ..... 
    public function addSeller(Request $request)
    {
        try 
        {
            $user = array('name'=> $request->name,'role'=> 3 ,'email' => $request->email,'phone'=>$request->phone,'password'=> bcrypt($request->password));
            $result = User::create($user)->id;
            // created on user tabels ........
            try{

                $shopId = Shop::where('user_id',$request->user()->id)->value('id');
                $dist = array('user_id' => $result,'shop_id' => $shopId, 'parent_id' => $request->user()->id,'country'=> $request->country, 'city' => $request->city,'state' => $request->state,'alt_phone' => $request->alt_phone,'address' => $request->address);
                $data = Seller::create($dist)->id;
                // created on Seller tabels ........
                try{
                        // created on Setting tabels ........
                    $setting = array('user_id' => $result, 'parent_id' => $request->user()->id,'access_name'=> 'shop,workers','parmition'=>1);
                    $settingLastId = Setting::create($setting)->id;
                    return response()->json(['success'=>'Seller create successfully.']);
                }
                catch(\Illuminate\Database\QueryException $settingEx)
                {
                    Seller::where('id',Seller::latest('id')->value('id'))->delete();  
                    User::where('id',User::latest('id')->value('id'))->delete();                  
                    return response()->json(['error'=>'Something wrong please try again']);
                }
            }
            catch(\Illuminate\Database\QueryException $SellerEx)
            {
                if($SellerEx)
                {
                    $deleteId = User::where('id',User::latest('id')->value('id'))->delete();
                    return response()->json(['error'=>$SellerEx]);
                }   
            }
        } 
        catch(\Illuminate\Database\QueryException $userEx)
        {
            if($userEx){
                return response()->json('User Exception');
            }
        }
    }

    public function getSellers(Request $request)
    {
        $skipId = json_decode($request->skip_id);
        $sellerIds = Seller::where('parent_id',$request->user()->id)->pluck('user_id');
        $users = User::whereIn('id',$sellerIds)->skip($skipId)->take(8)->get();
        return response()->json(['data' => $users]);
    }
}
