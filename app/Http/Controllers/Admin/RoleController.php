<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => "role"]);
            return $next($request);
        });
    }
    function list()
    {
        $roles = Role::all();
        return view(
            "admin.role.list",
            compact(
                "roles"
            )
        );
    }
    function add()
    {
        $permissions = Permission::where("parent_id", 0)->get();
        return view(
            "admin.role.add",
            compact("permissions")
        );
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'display_name' => ['required', 'string', 'max:255'],
                'permission_id' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'permission_id.required' => "Cần chọn vai trò",
            ],
            [
                'name' => "Tên vai trò",
                'display_name' => "Mô tả vai trò",
            ]
        );
        $idRole = DB::table('roles')->insertGetId([
            'role_name' => $request->name,
            'display_name' => $request->display_name,
        ]);
        $role = Role::find($idRole);
        $role->permissions()->attach($request->permission_id);
        return redirect('admin/role/add')->with('status', 'Đã thêm vai trò thành công');
    }
    function edit($id)
    {
        $permissions = Permission::where("parent_id", 0)->get();
        $infoRole = Role::find($id);
        $permission = Role::find($id)->permissions;

        return view("admin.role.edit", compact(
            'permissions',
            'permission',
            'infoRole',
        ));
    }
    function update(Request $request, $id){
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'display_name' => ['required', 'string', 'max:255'],
                'permission_id' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'permission_id.required' => "Cần chọn vai trò",
            ],
            [
                'name' => "Tên vai trò",
                'display_name' => "Mô tả vai trò",
            ]
        );
        Role::where("id",$id)->update([
            'role_name' => $request->name,
            'display_name' => $request->display_name,
        ]);
        $role = Role::find($id);
        $role->permissions()->sync($request->permission_id);
        return redirect("admin/role/edit/{$id}")->with('status', 'Đã cập nhật thành công');
    }
    function delete($id) {
        $role = Role::find($id);
        $role->delete();
        $role->permissions()->detach();
        return redirect("admin/role/list")->with('status', 'Đã xóa thành công');
    }
}