<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'user_id','shop_id', 'brand_name',
    ];

    public function categories()
    {
        return $this->hasMany('App\models\Category', 'brand_id', 'id');
    }

}

