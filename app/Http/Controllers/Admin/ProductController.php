<?php

namespace App\Http\Controllers\Admin;

use App\product_cat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\product_color;
use App\product_thumb;
use App\Trademark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    //
    private $htmlOptionCat;
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });
        $this->htmlOptionCat = "";
    }
    function add()
    {
        $product_cats = product_cat::where('parent_id', 0)->get();
        $trademarks = Trademark::all();
        return view('admin.product.add', compact('product_cats', 'trademarks'));
    }
    function storeProduct(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'price' => ['required', 'numeric'],
                'old_price' => ['required', 'numeric'],
                'file' => ['required', 'image', 'mimes:jpg,png,jpeg'],
                'detail' => ['required', 'string'],
                'desc' => ['required', 'string'],
                'cat' => ['required'],
                // 'child_cat' => ['required'],
                // 'trademark' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg',
                'unique' => ":attribute đã tồn tại",
            ],
            [
                'name' => "Tên sản phẩm",
                'price' => "Giá mới",
                'old_price' => "Giá cũ",
                'detail' => "Chi tiết sản phẩm",
                'desc' => "Mô tả sản phẩm",
                'cat' => "Danh mục cha",
                // 'child_cat' => "Danh mục con",
                // 'trademark' => "Thương hiệu",
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/products/";
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
            $file->move('public/uploads/products', $upload_file);
        }
        Product::create([
            'product_name' => $request->name,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'detail' => $request->detail,
            'desc' => $request->desc,
            'product_thumb' => $upload_file,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'product_cat_id' => $request->cat,
            // 'child_cat_id' => $request->child_cat,
            // 'trademark_id' => $request->trademark,
            'product_slug' =>  Str::slug($request->name, '-')
        ]);
        return redirect('admin/product/add')->with('status', 'Đã thêm sản phẩm thành công');
    }
    function list(Request $request)
    {
        $keyword = "";
        if ($request->keyword) {
            $keyword = $request->keyword;
        }
        $list_act = array(
            'delete' => "Xóa tạm thời",
            'notEmpty' => 'Còn hàng',
            'Empty' => 'Hết hàng',
        );

        $products = Product::select('products.*', 'users.name', "product_cats.cat_name")
            ->join('users', 'products.user_id', '=', 'users.id')
            ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
            // ->join('trademarks', 'products.trademark_id', '=', 'trademarks.id')
            ->where('product_name', 'LIKE', "%{$keyword}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $status = $request->status;
        if (isset($status)) {
            $products = Product::select('products.*', 'users.name', "product_cats.cat_name")
                ->join('users', 'products.user_id', '=', 'users.id')
                ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                // ->join('trademarks', 'products.trademark_id', '=', 'trademarks.id')
                ->where('product_name', 'LIKE', "%{$keyword}%")
                ->where("products.status", $status)
                ->paginate(10);
            $list_act = array(
                'delete' => "Xóa tạm thời",
                'Empty' => 'Hết hàng',
            );
        }
        if ($request->status == "0") {
            $list_act = array(
                'delete' => "Xóa tạm thời",
                'notEmpty' => 'Còn hàng',
            );
        }
        if ($request->status == "1") {
            $list_act = array(
                'delete' => "Xóa tạm thời",
                'Empty' => 'Hết hàng',
            );
        }
        if ($request->status == "trash") {
            $products = Product::onlyTrashed()
                ->select('products.*', 'users.name', "product_cats.cat_name")
                ->join('users', 'products.user_id', '=', 'users.id')
                ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                // ->join('trademarks', 'products.trademark_id', '=', 'trademarks.id')
                ->where('product_name', 'LIKE', "%{$keyword}%")
                ->paginate(10);
            $list_act = array(
                'forceDelete' => "Xóa vĩnh viễn",
                'restore' => 'Khôi phục',
            );
        }
        $countProduct = Product::count();
        $countProductPublish = Product::where('status', '1')->count();
        $countProductPending = Product::where('status', '0')->count();
        $countProductTrash = Product::onlyTrashed()->count();
        $counts = [$countProduct, $countProductPublish, $countProductPending, $countProductTrash];
        $orderProduct = json_encode($products);
        $orderProduct = json_Decode($orderProduct);
        $stt = $orderProduct->from;
        return view('admin.product.list', compact('products', 'counts', 'list_act', 'stt'));
    }
    function action(Request $request)
    {
        $action = $request->act;
        if (empty($action)) {
            return redirect('admin/product/list')->with('act_danger', 'Chưa chọn hành động');
        } else {
            $listcheck = $request->listcheck;
            if (empty($listcheck)) {
                return redirect('admin/product/list')->with('act_danger', 'Chưa chọn sản phẩm');
            } else {
                if ($action == 'delete') {
                    Product::destroy($listcheck);
                    return redirect('admin/product/list')->with('act_danger', 'Đã xóa bài viết thành công');
                }
                if ($action == 'forceDelete') {
                    Product::onlyTrashed()->whereIn('id', $listcheck)->forceDelete();
                    return redirect('admin/product/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn bài viết thành công');
                }
                if ($action == 'restore') {
                    Product::onlyTrashed()->whereIn('id', $listcheck)->restore();
                    return redirect('admin/product/list')->with('act_success', 'Đã khôi phục bài viết thành công');
                }
                if ($action == 'Empty') {
                    Product::whereIn('id', $listcheck)->update(
                        [
                            'status' =>  '0',
                        ]
                    );
                    return redirect('admin/product/list')->with('act_success', 'Đã cập nhật bài viết thành công');
                }
                if ($action == 'notEmpty') {
                    Product::whereIn('id', $listcheck)->update(
                        [
                            'status' =>  '1',
                        ]
                    );
                    return redirect('admin/product/list')->with('act_success', 'Đã cập nhật bài viết thành công');
                }
            }
        }
    }
    function trademark()
    {
        $trademarks = Trademark::select('trademarks.*', 'users.name')
            ->join('users', 'trademarks.user_id', '=', 'users.id')
            ->orderBy('trademarks.created_at', 'desc')
            ->paginate(6);
        return view('admin.product.trademark', compact('trademarks'));
    }
    function trademarkDelete($id)
    {
        $trademark = Trademark::find($id);
        $trademark->delete();
        return redirect('admin/product/trademark')->with('danger', 'Đã xóa thương hiệu thành công');
    }
    function storeTrademark(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
            ],
            [
                'required' => "Tên thương hiệu không được để trống",
            ]
        );
        Trademark::create([
            'trademark_name' =>  $request->name,
            'user_id' => Auth::id()
        ]);
        return redirect('admin/product/trademark')->with('status', 'Đã thêm thương hiệu thành công');
    }
    function edit($id)
    {
        $product = Product::find($id);
        $product_cats = product_cat::where('parent_id', 0)->get();
        $child_cats = product_cat::where('parent_id', $product->product_cat_id)->get();
        // $trademarks = Trademark::all();
        return view('admin.product.edit', compact('product', 'product_cats'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'price' => ['required', 'numeric'],
                'old_price' => ['required', 'numeric'],
                'file' => ['image', 'mimes:jpg,png,jpeg'],
                'detail' => ['required', 'string'],
                'desc' => ['required', 'string'],
                'cat' => ['required'],
                // 'child_cat' => ['required'],
                // 'trademark' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg',
                'unique' => ":attribute đã tồn tại",
            ],
            [
                'name' => "Tên sản phẩm",
                'price' => "Giá mới",
                'old_price' => "Giá cũ",
                'detail' => "Chi tiết sản phẩm",
                'desc' => "Mô tả sản phẩm",
                'cat' => "Danh mục cha",
                // 'child_cat' => "Danh mục con",
                // 'trademark' => "Thương hiệu",
            ]
        );
        $product = Product::find($id);
        $upload_file = $product->product_thumb;
        // return $upload_file;
        if ($request->hasFile('file')) {
            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/products/";
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
            File::delete($product->product_thumb);
            $file->move('public/uploads/products', $upload_file);
        }
        Product::where('id', $id)->update(
            [
                'product_name' => $request->name,
                'price' => $request->price,
                'old_price' => $request->old_price,
                'detail' => $request->detail,
                'desc' => $request->desc,
                'product_thumb' => $upload_file,
                'status' => $request->status,
                'user_id' => Auth::id(),
                'product_cat_id' => $request->cat,
                // 'child_cat_id' => $request->child_cat,
                // 'trademark_id' => $request->trademark,
                'product_slug' =>  Str::slug($request->name, '-')
            ]
        );
        return redirect("admin/product/edit/{$id}")->with('status', 'Đã cập nhật sản phẩm thành công');
    }
    function delete($id)
    {
        $product = Product::find($id);
        File::delete($product->product_thumb);
        $product->delete();
        return redirect('admin/product/list')->with('act_danger', 'Đã xóa sản phẩm thành công');
    }
    function forceDelete($id)
    {
        Product::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('admin/product/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn bài viết thành công');
    }
    function restore($id)
    {
        Product::onlyTrashed()->where('id', $id)->restore();
        return redirect('admin/product/list?status=trash')->with('act_success', 'Đã khôi phục bài viết thành công');
    }
    function listColor()
    {
        $colors = product_color::select('product_colors.*', 'users.name')
            ->join('users', 'product_colors.user_id', '=', 'users.id')
            ->paginate(6);
        return view('admin.product.img', compact('colors'));
    }
    function storeColor(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:100'],
                'color' => ['required']
            ],
            [
                'name.required' => "Màu sản phẩm không được để trống",
                'color.required' => "Chưa chọn màu",
            ]
        );
        product_color::create([
            'color_name' =>  $request->name,
            "color_order" => $request->color,
            'user_id' => Auth::id()
        ]);
        return redirect('admin/product/listColor')->with('status', 'Đã thêm màu sản phẩm thành công');
    }
    function colorDelete($id)
    {
        $color = product_color::find($id);
        $color->delete();
        return redirect('admin/product/listColor')->with('danger', 'Đã xóa màu sản phẩm thành công');
    }
    function moreImage($id)
    {
        $product = Product::select('products.id', 'product_name', 'product_thumbs.color_id')
            ->join('product_thumbs', 'product_thumbs.product_id', '=', 'products.id')
            ->where('product_thumbs.product_id', $id)
            ->first();
        if (empty($product)) {
            $product = Product::find($id);
        }
        $colors = product_color::select('color_name', 'id', "color_order")->get();
        $thumbs = product_thumb::select('product_thumbs.*', "users.name")
            ->join('users', 'product_thumbs.user_id', '=', 'users.id')
            ->where('product_id', $id)
            ->get();
        if (empty($thumbs)) {
            $thumbs = "";
        }
        if (!empty($product->color_id) && $product->color_id != null) {
            $thumbs = product_thumb::select('product_thumbs.*', "product_colors.color_name", "users.name")
                ->join('product_colors', 'product_thumbs.color_id', '=', 'product_colors.id')
                ->join('users', 'product_thumbs.user_id', '=', 'users.id')
                ->where('product_id', $id)
                ->paginate(6);
        }
        // return $thumbs;
        return view('admin.product.moreImage', compact('colors', 'product', 'thumbs'));
    }
    function storeImage(Request $request, $id)
    {
        $request->validate(
            [
                'file' => ['required', 'image', 'mimes:jpg,png,jpeg'],
                // 'color' => ['required']
            ],
            [
                'required' => ":attribute không được để trống",
                'image' => "Cần chọn đúng file ảnh",
                'mimes' => 'Cần chọn đúng file ảnh: jpg,png,jpeg',
            ],
            [
                'color' => 'Màu sản phẩm'
            ]
        );
        if ($request->hasFile('file')) {
            $file = $request->file;
            $file_image = $file->getClientOriginalName();
            $type = $file->getClientOriginalExtension();
            $upload_dir = "public/uploads/products/";
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
            $file->move('public/uploads/products', $upload_file);
        }
        product_thumb::create([
            'thumb_name' => $upload_file,
            'product_id' => $id,
            'color_id' => $request->color,
            'user_id' => Auth::id(),
        ]);
        return redirect("admin/product/moreImage/{$id}")->with('status', 'Đã thêm sản phẩm thành công');
    }
    function imageDelete($id)
    {
        $thumb = product_thumb::find($id);
        if (File::exists($thumb->thumb_name)) {
            File::delete($thumb->thumb_name);
        } else {
            dd('File does not exists.');
        }
        $thumb->delete();
        return back();
    }
    function selectedCat(Request $request)
    {
        $selectedCat = $request->selectedCat;
        $childCat = product_cat::where('parent_id', $selectedCat)
            ->where('parent_id', '>', 0)
            ->get();
        if ($childCat->isEmpty()) {
            echo "<option value=' '>Chưa chọn danh mục cha</option>";
            return;
        }
        $childCatHtml = "<option value=' '>Chọn danh mục con</option>";
        if (!empty($selectedCat)) {
            foreach ($childCat as $item) {
                $childCatHtml .= "<option value='{$item->id}'>{$item->cat_name}</option>";
            }
        }

        echo $childCatHtml;
    }
    //================
    // Cat
    //================
    function cat(Request $request)
    {
        //option1
        $product_cats = product_cat::select("product_cats.*","users.name")
        ->join("users","users.id",'=',"product_cats.user_id")
        ->get();
        $tree_product_cats = data_tree($product_cats);

        return view('admin.product.cat', compact('tree_product_cats'));
        
        //option2
        // $htmlOptionCat = $this->catRecursive(0);
        // return view('admin.product.cat', compact('htmlOptionCat'));

    }
    // cach 2:
    function catRecursive($id){
        $product_cats = product_cat::all();
        foreach ($product_cats as $item){
            if($item->parent_id === $id){
                $this->htmlOptionCat .= "<option value='{$item->id}'>{$item->cat_name}</option>";
                $this->catRecursive($item->id);
            }
        }
        return $this->htmlOptionCat;
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
        product_cat::create([
            'cat_name' =>  $request->name,
            'slug' =>  Str::slug($request->name, '-'),
            'status' => $request->status,
            'user_id' => Auth::id(),
            'parent_id' => $request->cat,
        ]);
        return redirect('admin/product/cat/list')->with('status', 'Đã thêm danh mục thành công');
    }
    function editCat($id)
    {
        $product_cat = product_cat::find($id);
        $product_cats = product_cat::select("product_cats.*","users.name")
        ->join("users","users.id",'=',"product_cats.user_id")
        ->get();
        $tree_product_cats = data_tree($product_cats);
        return view('admin.product.editCat', compact('product_cat', 'tree_product_cats'));
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
            return redirect("admin/product/cat/edit/{$id}")->with('danger', 'Không thể cập nhật danh mục cha');
        }
        product_cat::where('id', $id)->update(
            [
                'cat_name' =>  $request->name,
                'slug' =>  Str::slug($request->name, '-'),
                'status' => $request->status,
                'user_id' => Auth::id(),
                'parent_id' => $request->cat,
            ]
        );
        return redirect("admin/product/cat/edit/{$id}")->with('status', 'Đã cập nhật danh mục thành công');
    }
    function deleteCat($id)
    {
        $product_cat = product_cat::find($id);
        $product_cat->delete();
        return redirect('admin/product/cat/list')->with('danger', 'Đã xóa danh mục thành công');
    }
}
