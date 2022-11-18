<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_thumb extends Model
{
    //
    protected $fillable = ['thumb_name','product_id',"color_id","user_id"];
}
