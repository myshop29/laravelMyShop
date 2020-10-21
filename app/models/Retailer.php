<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $fillable = [
        'user_id', 'parent_id','country','city','state','alt_phone','address',
    ];
}
