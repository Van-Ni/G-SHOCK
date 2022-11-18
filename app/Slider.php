<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    protected $fillable = ['slider_name',"slider_thumb","slider_link","slider_order","status","user_id"];
}
