<?php

namespace App\Http\Controllers;

use App\Product;
use App\product_cat;
use App\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product_cat = product_cat::withCount('products')->get();

        $sellingPr = Product::orderBy('num_sold','desc')->limit(8)->get();

        $newPr = Product::orderBy('created_at','desc')->limit(8)->get();

        return view('home.index',compact('product_cat','sellingPr'));
    }
}
