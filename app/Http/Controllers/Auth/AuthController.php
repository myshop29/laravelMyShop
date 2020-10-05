<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Setting;
use App\models\Distributor;
class AuthController extends Controller
{
    public function login(Request $request) {

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])  || Auth::attempt(['phone' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response()->json([
                'access_token' => auth()->user()->createToken('authToken')->accessToken,
                'token_type' => 'Bearer',
                'user'=>auth()->user(),
                'sidebar'=>explode(",",Setting::where('user_id',auth()->user()->id)->value('access_name')),
            ]); 
        } 
        else{ 
            return response()->json(['error'=>'Invalid user or password']); 
        }
    }
    public function register(Request $request)
    {
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']);
        $input['role'] = 2; 
        $user = User::create($input); 
        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json(['message' => 'Successfully created user!','user'=>$user , 'access_token' => $accessToken]);
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  

    public function user2()
    {
        return response()->json(User::get());
    }
}
