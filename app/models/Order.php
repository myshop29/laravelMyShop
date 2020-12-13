<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'shop_id','order_type',
    ];

    public function orderHistory()
    {
        return $this->hasMany('App\models\Order_History', 'order_id', 'id');
    }
}
