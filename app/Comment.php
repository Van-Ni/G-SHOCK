<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $guarded = [];
    public function client(){
        return $this->belongsTo('App\Client');
    }
    public function child_comment(){
        return $this->hasMany('App\Comment','parent_id');
    }
}
