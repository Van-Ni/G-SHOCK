<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    //
    public function permissionChildrens(){
        // lấy ra ~ permission con thông qua parent_id
        return $this->hasMany("App\Permission",'parent_id');
    }
    public function roles(){
        return $this->belongsToMany('App\Role');
    }
}
