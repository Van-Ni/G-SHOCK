<?php

namespace App;

use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles()
    {
        // default :second argument: role_user
        return $this->belongsToMany("App\Role", "user_roles");
    }
    public function checkPermissionUser($permission)
    {
        /**
         * User hiện tại có roles nào ?
         * Roles này có permissionUser nào ?
         * Tham số $permission nó có  contain trong $permissionUser ko?
         */
        $roles = Auth::user()->roles;
        foreach ($roles as $role) {
            $permissionUser = $role->permissions;
            if ($permissionUser->contains('key_code', $permission))
                return true;
        }
        return false;
    }
}
