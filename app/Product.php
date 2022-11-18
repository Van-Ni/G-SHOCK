<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'product_name',
        'price',
        'old_price',
        'detail',
        'desc',
        'product_thumb',
        'status',
        'user_id',
        'product_cat_id',
        // 'child_cat_id',
        // 'trademark_id',
        'product_slug',
    ];
    public function cat(){
        return $this->belongsTo("App\product_cat","product_cat_id");
    }
    // public function child_cat(){
    //     return $this->belongsTo("App\product_cat","child_cat_id");
    // }
}
