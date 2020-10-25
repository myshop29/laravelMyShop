<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Setting;
use App\models\Distributor;

class DistributorController extends Controller
{
    // user and distributor tabels are create data with try catch block ..... 
    public function addDistributor(Request $request)
    {
        try 
        {
            $user = array('name'=> $request->name,'role'=> 1 ,'email' => $request->email,'phone'=>$request->phone,'password'=> bcrypt($request->password));
            $result = User::create($user)->id;
            // created on user tabels ........
            try{
                $dist = array('user_id' => $result, 'parent_id' => $request->user()->id,'country'=> $request->country, 'city' => $request->city,'state' => $request->state,'alt_phone' => $request->alt_phone,'address' => $request->address);
                $data = Distributor::create($dist)->id;
                // created on Distributor tabels ........
                try{
                        // created on Setting tabels ........
                    $setting = array('user_id' => $result, 'parent_id' => $request->user()->id,'access_name'=> 'shop,retailers,sellers,workers','parmition'=>1);
                    $settingLastId = Setting::create($setting)->id;
                    return response()->json(['success'=>'Distributor create successfully.']);
                }
                catch(\Illuminate\Database\QueryException $settingEx)
                {
                    Distributor::where('id',Distributor::latest('id')->value('id'))->delete();  
                    User::where('id',User::latest('id')->value('id'))->delete();                  
                    return response()->json(['error'=>'Something wrong please try again']);
                }
            }
            catch(\Illuminate\Database\QueryException $distributorEx)
            {
                if($distributorEx)
                {
                    $deleteId = User::where('id',User::latest('id')->value('id'))->delete();
                    return response()->json('please try again');
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

    // get distributors with limits ........................


    public function getDistributors(Request $request)
    {
        $skipId = json_decode($request->skip_id);
        $distributorIds = Distributor::where('parent_id',$request->user()->id)->pluck('user_id');
        $users = User::where('id',$distributorIds)->skip($skipId)->take(8)->get();
        return response()->json(['data' => $users]);
    }
}
