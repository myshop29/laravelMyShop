<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\models\Shop;
use App\models\Image;

class ImageController extends Controller
{

    public function uploadTakePhoto(Request $request)
    {

        if ($file = base64_decode($request['image'])) 
        {
            $destinationPath = public_path('role'.$request->user()->role.'/');;
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath);
            }
            $destinationPath = public_path('role'.$request->user()->role.'/product/');;
            if (!is_dir($destinationPath)) {
                mkdir($destinationPath);
            }
                
            try 
            {
                $time = md5(date("Y/m/d-H:ia")); 
                $imageName = Str::random(10).'.'.'jpeg';
                $profileImage = $time.'_'.$imageName;
                $productImages=  'role'.$request->user()->role.'/product/'.$profileImage;
                
                $product = array('image_url'=>$productImages,'image_type' => 'product_image','user_id' => $request->user()->id);
                $imageId = Image::create($product)->id;
                if($imageId){
                    $success = file_put_contents(public_path().'/role'.$request->user()->role.'/product/'.$profileImage, $file);
                    return response()->json(['success'=>'image upload successfully.','image_id' => $imageId]);
                }
                else{
                    return response()->json(['error'=>'please try once.']);
                }
            } 
            catch(\Illuminate\Database\QueryException $imageTableException)
            {
                if($imageTableException){
                    return response()->json(['error'=>$imageTableException]);
                }
            }
        }
        
        
        // if ($files = $request->file('productImage'))
        // {
        //     $destinationPath = public_path('role'.$request->role.'/');;
        //     if (!is_dir($destinationPath)) {
        //         mkdir($destinationPath);
        //     }
        //     $destinationPath = public_path('role'.$request->role.'/product/');;
        //     if (!is_dir($destinationPath)) {
        //         mkdir($destinationPath);
        //     }
        //     foreach($files as $img) {   
        //     $time = md5(date("Y/m/d-H:ia"));     
        //     $profileImage = $time.'_'.$img->getClientOriginalName();
        //     $img->move($destinationPath, $profileImage);
        //         $images[] =  'role'.$request->role.'/product/'.$profileImage;
        //     }
        //     $productImages = implode(",",$images);
        //                 $product = array('product_image'=>$productImages);
        //     $result = Product::create($product)->id;
        //     if ($result) {
                
        //         return response()->json(['product_id' => $result, 'success' =>'Product Add Successfull']); 
        //     } else {
        //         return response()->json(['error' =>'please try again']);    
        //     }
        // }
    }
}
