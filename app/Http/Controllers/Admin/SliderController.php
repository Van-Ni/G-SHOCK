<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slider']);
            return $next($request);
        });
    }
    function index()
    {
        $sliders = Slider::select('sliders.*', 'users.name')
            ->join('users', 'sliders.user_id', '=', 'users.id')
            ->orderBy('slider_order', 'asc')
            ->paginate(6);
        return view('admin.slider.index', compact('sliders'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required'],
                'link' => ['required'],
                'order' => ['required'],
                'file' => ['required','image', 'mimes:jpg,png,jpeg'],
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg'
            ],
            [
                'name' => 'Tên slider',
                'link' => 'Link slider',
                'order' => 'Số thứ tự',
                'file' => 'Ảnh slider',
            ]
        );
        if ($request->hasFile('file')) {

            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/sliders/";
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
            $file->move('public/uploads/sliders', $upload_file);
        }
        Slider::create([
            'slider_name' => $request->name,
            'slider_thumb' => $upload_file,
            'slider_link' => $request->link,
            'slider_order' => $request->order,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);
        return redirect('admin/slider/list')->with('status', 'Đã thêm slider thành công');
    }
    function delete($id)
    {
        $slider = Slider::find($id);
        $slider->delete();
        return redirect('admin/slider/list')->with('danger', 'Đã xóa slider thành công');
    }
    function edit($id)
    {
        $slider = Slider::find($id);
        $sliders = Slider::select('sliders.*', 'users.name')
            ->join('users', 'sliders.user_id', '=', 'users.id')
            ->orderBy('slider_order', 'asc')
            ->paginate(6);
        return view('admin.slider.edit', compact('sliders', 'slider'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required'],
                'link' => ['required'],
                'order' => ['required'],
                'file' => ['image', 'mimes:jpg,png,jpeg'],
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg'
            ],
            [
                'name' => 'Tên slider',
                'link' => 'Link slider',
                'order' => 'Số thứ tự',
                'file' => 'Ảnh slider',
            ]
        );
        $slider = Slider::find($id);
        $upload_file = $slider->slider_thumb;
        if ($request->hasFile('file')) {

            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/sliders/";
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
            $file->move('public/uploads/sliders', $upload_file);
        }
        Slider::where('id', $id)->update(
            [
                'slider_name' => $request->name,
                'slider_thumb' => $upload_file,
                'slider_link' => $request->link,
                'slider_order' => $request->order,
                'status' => $request->status,
                'user_id' => Auth::id(),
            ]
        );
        return redirect("admin/slider/edit/{$id}")->with('status', 'Đã cập nhật slider thành công');
    }
}
