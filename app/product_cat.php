<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_cat extends Model
{
    //
    protected $fillable = ['cat_name','slug','status','user_id','parent_id'];
    public function childCat(){
        return $this->hasMany('App\product_cat','parent_id');
    }
    public function products(){
        return $this->hasMany('App\Product');
    }
}
