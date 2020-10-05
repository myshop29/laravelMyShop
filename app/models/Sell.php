<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $fillable = [
        'user_id', 'total_amount','total_selling_price',
    ];
}
