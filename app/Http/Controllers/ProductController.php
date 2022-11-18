<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Product;
use App\Trademark;
use App\product_cat;
use App\product_thumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    function list(Request $request)
    {
        // cat
        $cats = product_cat::where('status', '1')->get();
        // líst products
        $products = Product::paginate(12);
        /* $valuePrice =  $request->input('r_price');
        $valueBrand =  $request->input('r_brand');
        $valueArrange =  $request->input('arrange');
        if (!empty($valuePrice)) {
            switch ($valuePrice) {
                case "1":
                    $products = Product::where('price', "<", 500000)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::whereBetween('price', [500000, 1000000])
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::whereBetween('price', [1000000, 5000000])
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::whereBetween('price', [5000000, 10000000])
                        ->paginate(20);
                    break;
                case "5":
                    $products = Product::where('price', ">", 10000000)
                        ->paginate(20);
                    break;
            }
        }
        if (!empty($valueBrand)) {
            $products = Product::whereIn('trademark_id', $valueBrand)
                ->paginate(20);
        }
        if (!empty($valuePrice) && !empty($valueBrand)) {
            switch ($valuePrice) {
                case "1":
                    $products = Product::where('price', "<", 500000)
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::whereBetween('price', [500000, 1000000])
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::whereBetween('price', [1000000, 5000000])
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::whereBetween('price', [5000000, 10000000])
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "5":
                    $products = Product::where('price', ">", 10000000)
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
            }
        }
        // arrange
        if (!empty($valueArrange)) {
            switch ($valueArrange) {
                case "1":
                    $products = Product::orderBy('product_name', 'asc')
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::orderBy('product_name', 'desc')
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::orderBy('price', 'desc')
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::orderBy('price', 'asc')
                        ->paginate(20);
                    break;
            }
        } */
        // search 
        if (!empty($request->keyword)) {
            $products = Product::where('product_name', 'LIKE',  "%{$request->keyword}%")
                ->paginate(3);
        }
        return view('product.list', compact(
            'products',
            'cats'
        ));
    }
    function cat(Request $request, $parent_cat)
    {
        $cats = product_cat::where('status', '1')->get();
        $product_cats = json_decode($cats, true);
        $tree_product_cats = re_index($product_cats, 1);
        $trademarks = Product::select('trademarks.id', 'trademarks.trademark_name')
            ->join('trademarks', 'trademarks.id', '=', 'products.trademark_id')
            ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
            ->where('product_cats.slug', $parent_cat)
            ->groupBy('trademarks.id')
            ->groupBy('trademarks.trademark_name')
            ->get();
        // cat_name 
        $cat_name = product_cat::select('cat_name', 'slug')
            ->where("slug", $parent_cat)->get();
        // list products
        $products = Product::select('products.*')
            ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
            ->where("product_cats.slug", $parent_cat)
            ->paginate(20);
        $valuePrice =  $request->input('r_price');
        $valueBrand =  $request->input('r_brand');
        $valueArrange =  $request->input('arrange');
        if (!empty($valuePrice)) {
            switch ($valuePrice) {
                case "1":
                    $products = Product::select('products.*')
                        ->where('price', "<", 500000)
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::select('products.*')
                        ->whereBetween('price', [500000, 1000000])
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::select('products.*')
                        ->whereBetween('price', [1000000, 5000000])
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::select('products.*')
                        ->whereBetween('price', [5000000, 10000000])
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "5":
                    $products = Product::select('products.*')
                        ->where('price', ">", 10000000)
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
            }
        }
        if (!empty($valueBrand)) {
            $products = Product::select('products.*')->whereIn('trademark_id', $valueBrand)
                ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                ->where("product_cats.slug", $parent_cat)
                ->paginate(20);
        }
        if (!empty($valuePrice) && !empty($valueBrand)) {
            switch ($valuePrice) {
                case "1":
                    $products = Product::select('products.*')->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->where('price', "<", 500000)
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::select('products.*')->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->whereBetween('price', [500000, 1000000])
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::select('products.*')->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->whereBetween('price', [1000000, 5000000])
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::select('products.*')->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->whereBetween('price', [5000000, 10000000])
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
                case "5":
                    $products = Product::select('products.*')->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->where('price', ">", 10000000)
                        ->whereIn('trademark_id', $valueBrand)
                        ->paginate(20);
                    break;
            }
        }
        // arrange
        if (!empty($valueArrange)) {
            switch ($valueArrange) {
                case "1":
                    $products = Product::select('products.*')->orderBy('product_name', 'asc')
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::select('products.*')->orderBy('product_name', 'desc')
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::select('products.*')->orderBy('price', 'desc')
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::select('products.*')->orderBy('price', 'asc')
                        ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $parent_cat)
                        ->paginate(20);
                    break;
            }
        }
        return view('product.cat', compact(
            'cat_name',
            'tree_product_cats',
            'trademarks',
            'products',
        ));
    }
    function childCat(Request $request, $parent_cat, $child_cat)
    {
        $parent_cat = $parent_cat;
        $cats = product_cat::where('status', '1')->get();
        $product_cats = json_decode($cats, true);
        $tree_product_cats = re_index($product_cats, 1);
        // cat_name 
        $cat_name = product_cat::select('cat_name', 'slug')
            ->where("slug", $child_cat)->get();
        // list products
        $products = Product::select('products.*')->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
            ->where("product_cats.slug", $child_cat)
            ->paginate(20);
        $valuePrice =  $request->input('r_price');
        $valueArrange =  $request->input('arrange');
        if (!empty($valuePrice)) {
            switch ($valuePrice) {
                case "1":
                    $products = Product::select('products.*')->where('price', "<", 500000)
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::select('products.*')->whereBetween('price', [500000, 1000000])
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::select('products.*')->whereBetween('price', [1000000, 5000000])
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::select('products.*')->whereBetween('price', [5000000, 10000000])
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "5":
                    $products = Product::select('products.*')->where('price', ">", 10000000)
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
            }
        }
        if (!empty($valueBrand)) {
            $products = Product::select('products.*')->whereIn('trademark_id', $valueBrand)
                ->join('product_cats', 'products.product_cat_id', '=', 'product_cats.id')
                ->where("product_cats.slug", $child_cat)
                ->paginate(20);
        }
        // arrange
        if (!empty($valueArrange)) {
            switch ($valueArrange) {
                case "1":
                    $products = Product::select('products.*')->orderBy('product_name', 'asc')
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "2":
                    $products = Product::select('products.*')->orderBy('product_name', 'desc')
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "3":
                    $products = Product::select('products.*')->orderBy('price', 'desc')
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
                case "4":
                    $products = Product::select('products.*')->orderBy('price', 'asc')
                        ->join('product_cats', 'products.child_cat_id', '=', 'product_cats.id')
                        ->where("product_cats.slug", $child_cat)
                        ->paginate(20);
                    break;
            }
        }
        return view('product.childCat', compact(
            'cat_name',
            'tree_product_cats',
            'products',
            'parent_cat'
        ));
    }
    function detailProduct($product, $id)
    {
        // detail product
        $product = Product::find($id);
        // image relative
        $product_imgs = product_thumb::select('thumb_name')
             ->join('products', 'products.id', '=', 'product_thumbs.product_id')
             ->where('product_id', $id)
             ->get();
        // image relative
       /*  $product_imgs = product_thumb::select('thumb_name')
            ->join('products', 'products.id', '=', 'product_thumbs.product_id')
            ->where('product_id', $id)
            ->get();
        //colors
        $product_colors = product_thumb::select('product_thumbs.*', "product_colors.color_name")
            ->join('products', 'products.id', '=', 'product_thumbs.product_id')
            ->join('product_colors', 'product_colors.id', '=', 'product_thumbs.color_id')
            ->where('product_id', $id)
            ->orderBy('product_thumbs.id', 'asc')
            ->get();
        // same category
        $same_pr = Product::select("products.*")
            ->where('child_cat_id', $child_cat->id)
            ->take(8)->get(); */
        
        return view('product.detail', compact('product','product_imgs'));
    }
    function liveSearch()
    {
        $value = isset($_POST['val']) ? $_POST['val'] : "";
        $products = Product::where('status', '1')
            ->where('product_name', 'LIKE', "%{$value}%")
            ->get();
        $liElement = "";
        if (!empty($products)) {
            foreach ($products as $item) {
                $href = url("san-pham/{$item->product_slug}.{$item->id}.html");
                $srcImg = asset("{$item->product_thumb}");
                $price = currency_format($item->price);
                $old_price = currency_format($item->old_price);
                $liElement .= "<li>
                <a href='{$href}'>
         <img src='{$srcImg}' alt=''>
         <div class='info-search'>
         <h4>{$item->product_name}</h4>
         <div class='price'>
            <span class='new'>{$price}</span>
             <span class='old'>{$old_price}</span>
         </div>
         </div>
         </a>";
            }
        } else {
            echo $liElement = "";
        }
        echo $liElement;
    }
    // ========
    // Login with ajax
    // ========
    function ajaxLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:clients',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            // return response()->json(['error' => $validator->errors()]);
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            $credentials = $request->only('email', 'password');
            if (Auth::guard('client')->attempt($credentials)) {
                // if(Auth::guard('client')->user()->status == 0){
                //     Auth::guard('client')->logout();
                //     return "Tài khoản của bạn chưa xác thực";
                // }
                return response()->json(['data' => Auth::guard('client')->user()]);
            }
        }
    }
    function ajaxComment(Request $request)
    {
        $parent_id = isset($request->parent_id) ? $request->parent_id : 0;
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ], [
            'required' => "Chưa nhập bình luận"
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()]);
        } else {
            Comment::create([
                'product_id' => $request->id,
                'client_id' => Auth::guard('client')->id(),
                'contents' => $request->comment,
                'parent_id' => $parent_id,
            ]);
            $comments = Comment::where([
                ['product_id', $request->id],
                ['parent_id', 0],
            ])
                ->orderBy("created_at", "desc")
                ->get();
            return view('components.listComment', compact('comments'));
        }
    }
}
