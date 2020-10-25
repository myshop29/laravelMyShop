<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [
        'user_id', 'parent_id','shop_id','country','city','state','alt_phone','address',
    ];
}
