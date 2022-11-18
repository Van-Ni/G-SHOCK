<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'order_code', 'list_product','total_order', 'total_price','status',
        'note','customer_id', 
    ];
}
