<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shop_id','brand_id', 'category_id','image_id','brand_name','category_name',
        'product_name','product_type','purchase_price','selling_price','disc_sell_price',
        'qty','total_pur_price',
    ];

    public function image()
    {
        return $this->hasOne('App\models\Image', 'id', 'image_id');
    }

    
}
