<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Setting;
use App\models\Retailer;

class RetailerController extends Controller
{

    // user and Retailer tabels are create data with try catch block ..... 
    public function addRetailer(Request $request)
    {
        try 
        {
            $user = array('name'=> $request->name,'role'=> 2 ,'email' => $request->email,'phone'=>$request->phone,'password'=> bcrypt($request->password));
            $result = User::create($user)->id;
            // created on user tabels ........
            try{
                $dist = array('user_id' => $result, 'parent_id' => $request->user()->id,'country'=> $request->country, 'city' => $request->city,'state' => $request->state,'alt_phone' => $request->alt_phone,'address' => $request->address);
                $data = Retailer::create($dist)->id;
                // created on Retailer tabels ........
                try{
                        // created on Setting tabels ........
                    $setting = array('user_id' => $result, 'parent_id' => $request->user()->id,'access_name'=> 'shop,sellers,workers','parmition'=>1);
                    $settingLastId = Setting::create($setting)->id;
                    return response()->json(['success'=>'Retailer create successfully.']);
                }
                catch(\Illuminate\Database\QueryException $settingEx)
                {
                    Retailer::where('id',Retailer::latest('id')->value('id'))->delete();  
                    User::where('id',User::latest('id')->value('id'))->delete();                  
                    return response()->json(['error'=>'Something wrong please try again']);
                }
            }
            catch(\Illuminate\Database\QueryException $retailerEx)
            {
                if($retailerEx)
                {
                    $deleteId = User::where('id',User::latest('id')->value('id'))->delete();
                    return response()->json(['error'=>'retailerEx please try again']);
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

    public function getRetailers(Request $request)
    {
        $skipId = json_decode($request->skip_id);
        $retaileeIds = Retailer::where('parent_id',$request->user()->id)->pluck('user_id');
        $users = User::whereIn('id',$retaileeIds)->skip($skipId)->take(8)->get();
        return response()->json(['data' => $users]);
    }
}
