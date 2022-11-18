<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use App\post_cat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }
    function add()
    {
        $post_cats = post_cat::select('post_cats.*', 'users.name')
            ->join('users', 'post_cats.user_id', '=', 'users.id')
            ->get();
            $tree_post_cats = data_tree($post_cats);
            return view('admin.post.add', compact('tree_post_cats'));
    }
    function addAjax()
    {
        
    }
    function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('admin/post/list')->with('status', 'Đã xóa bài viết thành công');
    }
    function forceDelete($id)
    {
        Post::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('admin/post/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn bài viết thành công');
    }
    function restore($id)
    {
        Post::onlyTrashed()->where('id', $id)->restore();
        return redirect('admin/post/list?status=trash')->with('act_success', 'Đã khôi phục bài viết thành công');
    }
    function edit($id)
    {
        $post = Post::find($id);
        $user = Post::select("");
        $post_cats = post_cat::select('post_cats.*', 'users.name')
        ->join('users', 'post_cats.user_id', '=', 'users.id')
        ->get();
        $post_cats = json_decode($post_cats, true);
        $tree_post_cats = array();
        if (count($post_cats) > 0) {
            $tree_post_cats = data_tree(re_index($post_cats, 1));
        }
        return view('admin.post.edit', compact('post', 'tree_post_cats'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => ['required'],
                'content' => ['required'],
                'file' => ['image'],
                'cat' => ['required'],
                'desc' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'cat' => 'Danh mục',
                'desc' => 'Mô tả',
            ]
        );
        $post = Post::find($id);
        $upload_file = $post->thumb;
        if ($request->hasFile('file')) {

            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/posts/";
            $upload_file = $upload_dir . $file_image;
            if (File::exists($upload_file)) {
                $file_name = pathinfo($file_image, PATHINFO_FILENAME);
                $new_file_name = $file_name . "-Copy.";
                $new_upload_file = $upload_dir . $new_file_name . $type;
                $k = 1;
                while (File::exists($new_upload_file)) {
                    $k++;
                    $new_file_name = $file_name . "-Copy({$k}).";
                    $new_upload_file = $upload_dir . $new_file_name . $type;
                }
                $upload_file = $new_upload_file;
            }
            $file->move('public/uploads/posts', $upload_file);
        }
        
        Post::where('id', $id)->update(
            [
                'title' =>  $request->title,
                'content' =>  $request->content,
                'desc' =>  $request->desc,
                'thumb' =>  $upload_file,
                'status' =>  $request->status,
                'user_id' => Auth::id(),
                'post_cat_id' => $request->cat,
                'post_slug' => Str::slug($request->title, '-')
            ]
        );
        
        return redirect("admin/post/edit/{$id}")->with('status', 'Đã cập nhật bài viết thành công');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'title' => ['required'],
                'content' => ['required'],
                'file' => ['required', 'image', 'mimes:jpg,png,jpeg'],
                'cat' => ['required'],
                'desc' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg'
            ],
            [
                'title' => 'Tiêu đề',
                'content' => 'Nội dung',
                'cat' => 'Danh mục',
                'desc' => 'Mô tả',
            ]
        );
        
        if ($request->hasFile('file')) {

            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/posts/";
            $upload_file = $upload_dir . $file_image;
            if (File::exists($upload_file)) {
                $file_name = pathinfo($file_image, PATHINFO_FILENAME);
                $new_file_name = $file_name . "-Copy.";
                $new_upload_file = $upload_dir . $new_file_name . $type;
                $k = 1;
                while (File::exists($new_upload_file)) {
                    $k++;
                    $new_file_name = $file_name . "-Copy({$k}).";
                    $new_upload_file = $upload_dir . $new_file_name . $type;
                }
                $upload_file = $new_upload_file;
            }
            $file->move('public/uploads/posts', $upload_file);
        }
        Post::create([
            'title' =>  $request->title,
            'content' =>  $request->content,
            'desc' =>  $request->desc,
            'thumb' =>  $upload_file,
            'status' =>  $request->status,
            'user_id' => Auth::id(),
            'post_cat_id' => $request->cat,
            'post_slug' => Str::slug($request->title, '-')
        ]);
        return redirect('admin/post/add')->with('status', 'Đã thêm bài viết thành công');
    }
    function action(Request $request)
    {
        $action = $request->act;
        if (empty($action)) {
            return redirect('admin/post/list')->with('act_danger', 'Chưa chọn hành động');
        } else {
            $listcheck = $request->listcheck;
            if (empty($listcheck)) {
                return redirect('admin/post/list')->with('list_check', 'Chưa chọn bài viết');
            } else {
                if ($action == 'delete') {
                    Post::destroy($listcheck);
                    return redirect('admin/post/list')->with('act_danger', 'Đã xóa bài viết thành công');
                }
                if ($action == 'forceDelete') {
                    Post::onlyTrashed()->whereIn('id', $listcheck)->forceDelete();
                    return redirect('admin/post/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn bài viết thành công');
                }
                if ($action == 'restore') {
                    Post::onlyTrashed()->whereIn('id', $listcheck)->restore();
                    return redirect('admin/post/list')->with('act_success', 'Đã khôi phục bài viết thành công');
                }
                if ($action == 'pending') {
                    Post::whereIn('id', $listcheck)->update(
                        [
                            'status' =>  '0',
                        ]
                    );
                    return redirect('admin/post/list')->with('act_success', 'Đã cập nhật bài viết thành công');
                }
                if ($action == 'publish') {
                    Post::whereIn('id', $listcheck)->update(
                        [
                            'status' =>  '1',
                        ]
                    );
                    return redirect('admin/post/list')->with('act_success', 'Đã cập nhật bài viết thành công');
                }
            }
        }
    }
    function list(Request $request)
    {
        $keyword = "";
        if ($request->keyword) {
            $keyword = $request->keyword;
        }
        $posts = Post::select('posts.*', 'users.name', 'post_cats.cat_name')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->join('post_cats', 'posts.post_cat_id', '=', 'post_cats.id')
            ->orderBy('created_at', 'desc')
            ->where('title', 'LIKE', "%{$keyword}%")
            ->paginate(6);
        $list_act = array(
            'delete' => "Xóa tạm thời",
            'pending' => 'Chờ duyệt',
            'publish' => 'Công khai',
        );
        // count
        if ($request->status == "1") {
            $posts = Post::select('posts.*', 'users.name', 'post_cats.cat_name')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('post_cats', 'posts.post_cat_id', '=', 'post_cats.id')
                ->orderBy('created_at', 'desc')
                ->where('title', 'LIKE', "%{$keyword}%")
                ->where('posts.status', "1")
                ->paginate(6);
            $list_act = array(
                'delete' => "Xóa tạm thời",
                'pending' => 'Chờ duyệt',
            );
        }
        if ($request->status == "0") {
            $posts = Post::select('posts.*', 'users.name', 'post_cats.cat_name')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('post_cats', 'posts.post_cat_id', '=', 'post_cats.id')
                ->orderBy('created_at', 'desc')
                ->where('title', 'LIKE', "%{$keyword}%")
                ->where('posts.status', "0")
                ->paginate(6);
            $list_act = array(
                'delete' => "Xóa tạm thời",
                'publish' => 'Công khai',
            );
        }
        if ($request->status == "trash") {
            $posts = Post::onlyTrashed()
                ->select('posts.*', 'users.name', 'post_cats.cat_name')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('post_cats', 'posts.post_cat_id', '=', 'post_cats.id')
                ->orderBy('created_at', 'desc')
                ->where('title', 'LIKE', "%{$keyword}%")
                ->paginate(6);
            $list_act = array(
                'forceDelete' => "Xóa vĩnh viễn",
                'restore' => 'Khôi phục',
            );
        }
        $countPost = Post::count();
        $countPostPublish = Post::where('status', '1')->count();
        $countPostPending = Post::where('status', '0')->count();
        $countPostTrash = Post::onlyTrashed()->count();
        $counts = [$countPost, $countPostPublish, $countPostPending, $countPostTrash];
        // show_arr($counts);
        $orderPost = json_encode($posts);
        $orderPost = json_Decode($orderPost);
        $stt = $orderPost->from;
        return view('admin.post.list', compact('posts', 'counts', 'list_act','stt'));
    }
    // ===================
    // CATEGORY
    // ===================
    function cat()
    {
        $post_cats = post_cat::select('post_cats.*', 'users.name')
            ->join('users', 'post_cats.user_id', '=', 'users.id')
            ->get();
            $tree_post_cats = data_tree($post_cats);
        return view('admin.post.cat', compact('tree_post_cats'));
    }
    function storeCat(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
            ],
            [
                'required' => "Tên danh mục không được để trống",
            ]
        );
        post_cat::create([
            'cat_name' =>  $request->name,
            'slug' =>  Str::slug($request->name, '-'),
            'status' => $request->status,
            'user_id' => Auth::id(),
            'parent_id' => $request->cat,
        ]);
        return redirect('admin/post/cat/list')->with('status', 'Đã thêm danh mục thành công');
    }
    function editCat($id)
    {
        $post_cat = post_cat::find($id);
        $post_cats = post_cat::select('post_cats.*', 'users.name')
            ->join('users', 'post_cats.user_id', '=', 'users.id')
            ->get();
        $post_cats = json_decode($post_cats, true);
        $tree_post_cats = array();
        if (count($post_cats) > 0) {
            $tree_post_cats = data_tree(re_index($post_cats, 1));
        }
        return view('admin.post.editCat', compact('post_cat', 'tree_post_cats'));
    }
    function updateCat(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
            ],
            [
                'required' => "Tên danh mục không được để trống",
            ]
        );
        if ($request->cat == $id) {
            return redirect("admin/post/cat/edit/{$id}")->with('danger', 'Không thể cập nhật danh mục cha');
        }
        post_cat::where('id', $id)->update(
            [
                'cat_name' =>  $request->name,
                'slug' =>  Str::slug($request->name, '-'),
                'status' => $request->status,
                'user_id' => Auth::id(),
                'parent_id' => $request->cat,
            ]
        );
        return redirect("admin/post/cat/edit/{$id}")->with('status', 'Đã cập nhật danh mục thành công');
    }
    function deleteCat($id)
    {
        $post_cat = post_cat::find($id);
        $post_cat->delete();
        return redirect('admin/post/cat/list')->with('status', 'Đã xóa danh mục thành công');
    }
    // ===================
    // END CATEGORY
    // ===================
}
