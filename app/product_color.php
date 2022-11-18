<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_color extends Model
{
    //
    protected $fillable = ['color_name','user_id',"color_order"];
}
