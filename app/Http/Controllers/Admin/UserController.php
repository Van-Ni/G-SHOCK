<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\user_role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => 'user']);
            return $next($request);
        });
    }
    function list(Request $request)
    {

        $keyword = "";
        if ($request->keyword) {
            $keyword = $request->keyword;
        }
        $users = User::select("users.*")
            ->where('name', 'LIKE', "%{$keyword}%")
            ->orWhere('email', 'LIKE', "%{$keyword}%")
            ->paginate(5);
        // tạo action
        $list_act = array(
            'delete' => "Xóa tạm thời"
        );
        if ($request->status == "trash") {
            $users = User::onlyTrashed()
                ->select("users.*")
                ->where('name', 'LIKE', "%{$keyword}%")
                ->paginate(5);
            // tạo action
            $list_act = array(
                'forceDelete' => "Xóa vĩnh viễn",
                'restore' => 'Khôi phục'
            );
        }
        $countUserActive = User::count();
        $countUserTrash = User::onlyTrashed()->count();
        $counts = [$countUserActive, $countUserTrash];
        return view('admin.user.list', compact('users', 'counts', 'list_act'));
    }
    function add()
    {
        $roles = Role::all();
        return view('admin.user.add',compact('roles'));
    }
    function edit($id)
    {
        $user = User::find($id);
        $user_roles = $user->roles()->orderBy('id','desc')->get();
        $roles = Role::all();
        return view('admin.user.edit', compact('user','roles','user_roles'));
    }
    function delete($id)
    {
        if (Auth::id() !== $id) {
            $user = User::find($id);
            $user->delete();
            $user->roles()->detach();
            return redirect('admin/user/list')->with('status', 'Đã xóa thành viên thành công');
        } else {
            return redirect('admin/user/list')->with('status', 'Không được xóa chính mình');
        }
    }
    function forceDelete($id)
    {
        User::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('admin/user/list?status=trash')->with('status', 'Đã xóa vĩnh viễn thành viên thành công');
    }
    function restore($id)
    {
        User::onlyTrashed()->where('id', $id)->restore();
        return redirect('admin/user/list?status=trash')->with('act_success', 'Đã khôi phục thành viên thành công');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'min' => ":attribute ít nhất :min ký tự",
                'max' => ":attribute tối đa :max ký tự",
                'unique' => ":attribute đã tồn tại",
                'role.required' => "Chưa cấp quyền cho thành viên",
                'confirmed' => "Xác nhận mật khẩu không thành công"
            ],
            [
                'name' => "Họ và tên",
                'email' => "Email",
                'password' => 'Mật khẩu',
            ]
        );
        $userCreate=User::create([
            'name' =>  $request->name,
            'email' =>  $request->email,
            'password' =>  Hash::make($request->password)
        ]);
        $user = User::find($userCreate->id);
        $user->roles()->attach($request->role);
        /**
         * take note: 
         * Tip 1: Dùng forEach để insert vào user_roles 
         * Tip 2: Dùng attach() để insert :
         */
        return redirect('admin/user/add')->with('status', 'Đã thêm thành viên thành công');
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],

            ],
            [
                'required' => ":attribute không được để trống",
                'min' => ":attribute ít nhất :min ký tự",
                'max' => ":attribute tối đa :max ký tự",
                'confirmed' => "Xác nhận mật khẩu không thành công"
            ],
            [
                'name' => "Họ và tên",
                'email' => "Email",
                'password' => 'Mật khẩu',
            ]
        );
        
        User::where('id', $id)->update(
            [
                'name' =>  $request->name,
                'email' => $request->email,
                'password' =>  Hash::make($request->password),
            ]
        );
        $user = User::find($id);
        $user->roles()->sync($request->role);
        return redirect("admin/user/edit/{$id}")->with('status', 'Đã cập nhật thành viên thành công');
    }
    function action(Request $request)
    {
        $action = $request->act;
        if (empty($action)) {
            return redirect('admin/user/list')->with('act_danger', 'Chưa chọn hành động');
        } else {
            $listcheck = $request->listcheck;
            foreach ($listcheck as $key => $id) {
                if (Auth::id() == $id) {
                    unset($listcheck[$key]);
                }
            }
            if (empty($listcheck)) {
                return redirect('admin/user/list')->with('list_check', 'Chưa chọn thành viên');
            } else {
                if ($action == 'delete') {
                    User::destroy($listcheck);
                    return redirect('admin/user/list')->with('act_danger', 'Đã xóa thành viên thành công');
                }
                if ($action == 'forceDelete') {
                    User::onlyTrashed()->whereIn('id', $listcheck)->forceDelete();
                    return redirect('admin/user/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn thành viên thành công');
                }
                if ($action == 'restore') {
                    User::onlyTrashed()->whereIn('id', $listcheck)->restore();
                    return redirect('admin/user/list')->with('act_success', 'Đã khôi phục thành viên thành công');
                }
            }
        }
    }
}
