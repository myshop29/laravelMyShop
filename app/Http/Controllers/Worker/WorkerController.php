<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Setting;
use App\models\Worker;
use App\models\Shop;

class WorkerController extends Controller
{
    // user and Seller tabels are create data with try catch block ..... 
    public function addWorker(Request $request)
    {
        try 
        {
            $user = array('name'=> $request->name,'role'=> 4 ,'email' => $request->email,'phone'=>$request->phone,'password'=> bcrypt($request->password));
            $result = User::create($user)->id;
            // created on user tabels ........
            try{

                $shopId = Shop::where('user_id',$request->user()->id)->value('id');
                $dist = array('user_id' => $result,'shop_id' => $shopId, 'parent_id' => $request->user()->id,'country'=> $request->country, 'city' => $request->city,'state' => $request->state,'alt_phone' => $request->alt_phone,'address' => $request->address);
                $data = Worker::create($dist)->id;
                // created on Worker tabels ........
                try{
                        // created on Setting tabels ........
                    $setting = array('user_id' => $result, 'parent_id' => $request->user()->id,'access_name'=> 'shop','parmition'=>1);
                    $settingLastId = Setting::create($setting)->id;
                    return response()->json(['success'=>'Worker create successfully.']);
                }
                catch(\Illuminate\Database\QueryException $settingEx)
                {
                    Worker::where('id',Worker::latest('id')->value('id'))->delete();  
                    User::where('id',User::latest('id')->value('id'))->delete();                  
                    return response()->json(['error'=>'Something wrong please try again']);
                }
            }
            catch(\Illuminate\Database\QueryException $WorkerEx)
            {
                if($WorkerEx)
                {
                    $deleteId = User::where('id',User::latest('id')->value('id'))->delete();
                    return response()->json(['error'=>$WorkerEx]);
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

    public function getWorkers(Request $request)
    {
        $skipId = json_decode($request->skip_id);
        $workerIds = Worker::where('parent_id',$request->user()->id)->pluck('user_id');
        $users = User::whereIn('id',$workerIds)->skip($skipId)->take(8)->get();
        return response()->json(['data' => $users]);
    }
}
