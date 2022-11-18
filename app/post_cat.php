<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class post_cat extends Model
{
    //
    protected $fillable = ['cat_name','slug','status','user_id','parent_id'];
}
