<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //
    function __construct(){
        $this->middleware(function ($request, $next) {
            session(['module_active'=>'permission']);
            return $next($request);
        });
    }
    function add(){
        return view('admin.permission.add');
    }
}
