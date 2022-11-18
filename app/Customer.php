<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $fillable = [
        'customer_name', 'email','address', 'phone_number',
    ];
}
