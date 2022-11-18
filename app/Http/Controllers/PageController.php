<?php

namespace App\Http\Controllers;

use App\Page;
use App\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    function detail($page){
        $page = Page::
        where('page_slug',$page)
        ->where('status',"1")
        ->get();
        $sellingPr = Product::orderBy("num_sold", 'desc')->take(8)->get();
        return view('page.detail',compact('page','sellingPr'));
    }
}
