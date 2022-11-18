<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    use SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
        'title', 'content','desc','thumb', 'status','user_id','post_cat_id','post_slug'
    ];
    public function cat(){
       return $this->belongsTo("App\post_cat");
    }
}
