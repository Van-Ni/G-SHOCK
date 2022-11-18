<?php

namespace App\Http\Controllers;

use App\Product;
use App\table_coupon_code;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    function list(){
        // Cart::destroy();
        // return Cart::content();
        
        return view("cart.list");

    }
    function addCart(Request $request, $id)
    {
        $color = isset($request->color) ? $request->color : 'NULL';
        $product = Product::find($id);
        Cart::add(
            $product->id,
            $product->product_name,
            $request->num_order,
            $product->price,
            [
                'thumb' => $product->product_thumb,
                "color" => $color,
                "slug" => $product->product_slug,
            ]
        );
        
        return redirect("/gio-hang");
    }
    function updateCart(){
        $qty = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
        $rowId = isset($_POST['rowId']) ? $_POST['rowId'] : 0;
        Cart::update($rowId, $qty);
        $product = Cart::get($rowId);
        $data = [
            'qty' => $product->qty,
            'subtotal' => currency_format($product->total),
            'total' => Cart::total()."₫",
            'total_qty'=> count(Cart::content())
        ];
        echo json_encode($data);
    }
    function deleteCart(){
        $rowId = isset($_POST['rowId']) ? $_POST['rowId'] : "";
        Cart::remove($rowId);
        echo $rowId;
        // return redirect("/gio-hang");
    }
    function destroyCart(){
        Cart::destroy();
        return redirect("/gio-hang");
    }
    function coupon(Request $request){
        $total = str_replace(".", "", Cart::total());
        $coupon_code = $request->coupon_code;
        $coupon = table_coupon_code::where("coupon_code", $coupon_code)->first();
        if($coupon->coupon_condition == 0 ){ 
            $total_coupon_number = ($total * $coupon->coupon_number) / 100;
            $info_sale = [
                'total' => $total,
                'coupon_number' => $coupon->coupon_number,
                'total_coupon_number' => $total_coupon_number,
                "total_discount" => $total - $total_coupon_number
            ];
            session(['info_sale' => $info_sale]);
        }
        if($coupon->coupon_condition == 1){
            
        }
        return redirect("/gio-hang");
    }
}
