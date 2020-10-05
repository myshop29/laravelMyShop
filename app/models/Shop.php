<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'user_id', 'shop_name','shop_phone','city','state','status','shop_address',
    ];
}
