<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'user_id','image_type','image_url',
    ];
}
