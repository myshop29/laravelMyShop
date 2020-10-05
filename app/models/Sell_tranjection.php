<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sell_tranjection extends Model
{
    protected $fillable = [
        'sell_id','shop_id','brand_id', 'category_id','image_id','brand_name','category_name',
        'product_name','product_type','purchase_price','selling_price','disc_sell_price',
        'qty',
    ];
}
