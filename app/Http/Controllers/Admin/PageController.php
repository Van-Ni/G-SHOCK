<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use function GuzzleHttp\Promise\all;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    //
    function __construct(){
        $this->middleware(function ($request, $next) {
            session(['module_active'=>'page']);
            return $next($request);
        });
    }
    function add()
    {
        return view('admin.page.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', 'string', 'max:100'],
                'content' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung'
            ]
        );
        $page = new Page;

        $page->title = $request->title;
        $page->content = $request->content;
        $page->status = $request->status;
        $page->page_slug = Str::slug($request->title,'-');
        $page->user_id = Auth::id();
        $page->save();
        // Page::create([
        //     'title' =>  $request->title,
        //     'content' =>  $request->content,
        //     'status' =>  $request->status,
        // ]);
        return redirect('admin/page/add')->with('status', 'Đã thêm trang thành công');
    }
    function edit($id)
    {
        $page = Page::find($id);
        return view('admin.page.edit', compact('page'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => ['required', 'string', 'max:100'],
                'content' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung'
            ]
        );
        Page::where('id', $id)->update(
            [
                'title' =>  $request->title,
                'content' =>  $request->content,
                'status' =>  $request->status,
            ]
        );
        return redirect("admin/page/edit/{$id}")->with('status', 'Đã cập nhật trang thành công');
    }
    function delete($id)
    {
        $page = Page::find($id);
        $page->delete();
        return redirect('admin/page/list')->with('status', 'Đã xóa trang thành công');
    }
    function forceDelete($id)
    {
        Page::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('admin/page/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn trang thành công');
    }
    function restore($id)
    {
        Page::onlyTrashed()->where('id', $id)->restore();
        return redirect('admin/page/list?status=trash')->with('act_success', 'Đã khôi phục trang thành công');
    }
    function list(Request $request)
    {
        if ($request->status == "trash") {
            $keyword = "";
            if ($request->keyword) {
                $keyword = $request->keyword;
            }
            $pages = Page::onlyTrashed()
            ->select('pages.*','users.name')
            ->join('users', 'pages.user_id', '=', 'users.id')
            ->orderBy('created_at','desc')
            ->where('title', 'LIKE', "%{$keyword}%")
            ->paginate(5);
            // tạo action
            $list_act = array(
                'forceDelete' => "Xóa vĩnh viễn",
                'restore' => 'Khôi phục'
            );
        } else {
            $keyword = "";
            if ($request->keyword) {
                $keyword = $request->keyword;
            }
            $pages = Page::select('pages.*','users.name')
            ->join('users', 'pages.user_id', '=', 'users.id')
            ->orderBy('created_at','desc')
            ->where('title', 'LIKE', "%{$keyword}%")
            ->paginate(5);
            // tạo action
            $list_act = array(
                'delete' => "Xóa tạm thời",
                'pending' => "Chờ duyệt",
                'public' => "Công khai",
            );
            $message = " hello bro ";
        }
        $countPageActive = Page::count();
        $countPageTrash = Page::onlyTrashed()->count();
        $counts = [$countPageActive, $countPageTrash];
        // one to one
        return view('admin.page.list', compact('pages','counts','list_act'));
    }
    function action(Request $request)
    {
        $action = $request->act;
        if (empty($action)) {
            return redirect('admin/page/list')->with('act_danger', 'Chưa chọn hành động');
        } else {
            $listcheck = $request->listcheck;
            if (empty($listcheck)) {
                return redirect('admin/page/list')->with('list_check', 'Chưa chọn trang');
            } else {
                if ($action == 'delete') {
                    Page::destroy($listcheck);
                    return redirect('admin/page/list')->with('act_danger', 'Đã xóa trang thành công');
                }
                if ($action == 'forceDelete') {
                    Page::onlyTrashed()->whereIn('id', $listcheck)->forceDelete();
                    return redirect('admin/page/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn trang thành công');
                }
                if ($action == 'restore') {
                    Page::onlyTrashed()->whereIn('id', $listcheck)->restore();
                    return redirect('admin/page/list')->with('act_success', 'Đã khôi phục trang thành công');
                }
                if ($action == 'pending') {
                    Page::whereIn('id', $listcheck)->update(
                        [
                            'status' =>  '0',
                        ]
                    );
                    return redirect('admin/page/list')->with('act_success', 'Đã cập nhật trang thành công');
                }
                if ($action == 'public') {
                    Page::whereIn('id', $listcheck)->update(
                        [
                            'status' =>  '1',
                        ]
                    );
                    return redirect('admin/page/list')->with('act_success', 'Đã cập nhật trang thành công');
                }
            }
        }
    }
}
