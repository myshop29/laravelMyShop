<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Order_History extends Model
{
    protected $fillable = [
        'order_id', 'order_image','customer_phone','product_name','order_price','advance_payment','delivery_date','status',
    ];
}
