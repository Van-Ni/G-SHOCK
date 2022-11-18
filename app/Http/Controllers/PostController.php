<?php

namespace App\Http\Controllers;

use App\Mail\OrderShip;
use App\Post;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    //
    function list()
    {
        $infoDemo = [
            "name" => "ni",
            "age" => 20
        ];
        // Mail::to("vanni4018@gmail.com")->send(new OrderShip($infoDemo));
        
        // $cat_name = Post::select('post_cats.cat_name')
        //     ->join('post_cats', 'posts.post_cat_id', '=', 'post_cats.id')
        //     ->where("post_cats.slug", $post_cat)
        //     ->groupBy('cat_name')
        //     ->get();
        $posts = Post::select('posts.*', 'post_cats.cat_name')
            ->join('post_cats', 'posts.post_cat_id', '=', 'post_cats.id')
            ->where('posts.status', "1")
            ->where('post_cats.status', "1")
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        // top selling products
        $sellingPr = Product::orderBy("num_sold", 'desc')->take(8)->get();
        return view('post.list', compact('posts', 'sellingPr'));
    }
    function detail($post_slug)
    {
        $post = Post::where('post_slug', $post_slug)->get();
        // top selling products
        $sellingPr = Product::orderBy("num_sold", 'desc')->take(8)->get();
        return view('post.detail', compact('post', 'sellingPr'));
    }
}