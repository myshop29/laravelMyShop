<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\models\Order;
use App\models\Order_History;
use App\models\Shop;

class OrderController extends Controller
{
    // user and Seller tabels are create data with try catch block ..... 
    public function addOrder(Request $request)
    {
        try{
            $orderType = $request->order_type;
            $order_id = Order::where('order_type',$orderType)->where('shop_id',$request->shop_id)->value('id');
            if ($order_id) {
                try {
                    $order = $request->all();
                    unset($order['shop_id'] , $order['order_type']);
                    $order['order_id'] = $order_id;
                    $orderHis = Order_History::create($order)->id;
                    return response()->json(['success'=> 'Success']);
                } catch (\Illuminate\Database\QueryException $OrderHistEx) {
                    return response()->json(['error'=>$OrderHistEx]);
                }  
            } else {
                try {
                    $orderArr = array('shop_id' => $request->shop_id , 'order_type' => $request->order_type);
                    $order_id = Order::create($orderArr)->id;
                    try {
                        $order = $request->all();
                        unset($order['shop_id'] , $order['order_type']);
                        $order['order_id'] = $order_id;
                        $orderHis = Order_History::create($order)->id;
                        return response()->json(['success'=> 'Success']);
                    } catch (\Illuminate\Database\QueryException $OrderHistoryEx) {
                        Order::where('id',$order_id)->delete();
                        return response()->json(['error'=>$OrderHistoryEx]);
                    }                    
                } catch (\Illuminate\Database\QueryException $OrderCreateEx) {
                    return response()->json(['error'=> 'Please try once']);
                }
            }
        }
        catch(\Illuminate\Database\QueryException $orderEx)
        {
            if($orderEx)
            {
                return response()->json(['error'=>$orderEx]);
            }   
        }
    }

    public function getOrder(Request $request)
    {
        $skipId = json_decode($request->skip_id);
        $shop_id = Shop::where('user_id',$request->user()->id)->pluck('id');
        $users = Order::whereIn('shop_id',$shop_id)->skip($skipId)->take(8)->with('orderHistory')->orderBy('order_type')->get();
        return response()->json( $users);
    }

    public function updateOrder(Request $request)
    {
        try {
            if ($request->update_id == 5 ) {
                $result = Order_History::where('id',$request->id)->delete();
            } else {
                $result = Order_History::where('id',$request->id)->update(['status' => $request->update_id]);
            }

            if (isset($result) && !empty($result)) {
                $getUpdateData = Order_History::where('order_id',$request->order_id)->get();
                return response()->json(['data' => $getUpdateData , 'success' => 'Update Success']);
           }
        } catch (\Illuminate\Database\QueryException $updateEx) {
            return response()->json( $updateEx);
        }
    }
}
