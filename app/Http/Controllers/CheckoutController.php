<?php

namespace App\Http\Controllers;

use App\Ward;
use App\Order;
use App\Customer;
use App\District;
use App\Province;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    //
    function successOrder(Request $request)
    {
        Cart::destroy();
        $orders = Order::where('order_code', $request->orderCode)->get();
        foreach ($orders as $item) {
            $list_product = $item->list_product;
        }
        $list_product = json_decode($list_product, true);
        // show_arr($list_product);
        return view('checkout.success', compact('orders', 'list_product'));
    }
    function checkout(Request $request)
    {
        $districts = "";
        $wards =  "";
        if (!empty($request->cookie('district'))) {
            $province = $request->cookie('province');
            // return $province;
            $districts = District::select("devvn_quanhuyen.*")
                ->join('devvn_tinhthanhpho', 'devvn_tinhthanhpho.matp', '=', 'devvn_quanhuyen.matp')
                ->where('devvn_tinhthanhpho.name', $province)->get();;
        }
        if (!empty($request->cookie('ward'))) {
            $district = $request->cookie('district');
            $wards = Ward::select("devvn_xaphuongthitran.*")
                ->join('devvn_quanhuyen', 'devvn_quanhuyen.maqh', '=', 'devvn_xaphuongthitran.maqh')
                ->where('devvn_quanhuyen.name', $district)->get();
        }
        $provinces = Province::all();
        return view(
            "checkout.index",
            compact(
                'provinces',
                'districts',
                'wards',
            )
        );
    }
    function storeCheckout(Request $request)
    {
        $valEmail = !empty($request->email) ? $request->email : "";
        $valFullAddress = $request->address . ", " . $request->ward . ", " . $request->district . ", " . $request->province;
        $order_code = "ISMART." . Str::random(4);
        $valNote = !empty($request->note) ? $request->note : "";
        $total_price =  str_replace(".", "", Cart::total());
        $request->validate(
            [
                'fullname' => ['required', 'string', 'max:255'],
                "phone" => ['required', 'regex:/^(09|03|07|08|05)+([0-9]{8})$/', 'max:10'],
                "province" => ['required'],
                "district" => ['required'],
                "address" => ['required'],
                "ward" => ['required'],
            ],
            [
                'required' => "Chưa nhập :attribute",
                'province.required' => "Chưa chọn :attribute",
                'district.required' => "Chưa chọn :attribute",
                'ward.required' => "Chưa chọn :attribute",
                'min' => ":attribute ít nhất :min ký tự",
                'max' => ":attribute tối đa :max ký tự",
                'unique' => ":attribute đã tồn tại",
            ],
            [
                'fullname' => "họ và tên",
                // 'email' => "email",
                'phone' => 'số điện thoại',
                "province" => "tỉnh / thành phố",
                "district" => "quận / huyện",
                "address" => "địa chỉ",
                "ward" => "phường / xã"
            ]
        );

        // set cookie
        $response = new Response();
        $fullname = Cookie::make('fullname', $request->fullname, 24 * 60);
        $phone = Cookie::make('phone', $request->phone, 24 * 60);
        $email = Cookie::make('email', $valEmail, 24 * 60);
        $province = Cookie::make('province', $request->province, 24 * 60);
        $district = Cookie::make('district', $request->district, 24 * 60);
        $ward = Cookie::make('ward', $request->ward, 24 * 60);
        $address = Cookie::make('address', $request->address, 24 * 60);
        $fullAddress = Cookie::make('fullAddress', $valFullAddress, 24 * 60);
        $note = Cookie::make('note', $valNote, 24 * 60);
        // check exist user
        $count_customer = Customer::select("*")
            ->where('customer_name', $request->fullname)
            ->where('phone_number', $request->phone)->count();
        // add customer

        if ($count_customer < 1) {
            Customer::create([
                'customer_name' => $request->fullname,
                'email' => $valEmail,
                'address' => $valFullAddress,
                'phone_number' => $request->phone,
            ]);
        } else {
            Customer::where('customer_name', $request->fullname)
                ->where('phone_number', $request->phone)
                ->update([
                    'email' => $valEmail,
                    'address' => $valFullAddress,
                ]);
        }
        //get id customer
        $info_customer = Customer::select("customers.id")
            ->where('customer_name', $request->fullname)
            ->where('phone_number', $request->phone)->get();;
        foreach ($info_customer as $item) {
            $customer_id = $item->id;
        }

        // add order
        Order::create([
            "order_code" => $order_code,
            "list_product" => Cart::content(),
            'total_order' => count(Cart::content()),
            'total_price' => $total_price,
            'note' => $valNote,
            "customer_id" => $customer_id
        ]);
        return redirect()->route('successOrder', ['orderCode' => $order_code])->withCookies([
            $fullname,
            $phone,
            $email,
            $province,
            $district,
            $ward,
            $address,
            $fullAddress,
            $note
        ]);
    }

    function getDistrict(Request $request)
    {
        $id = $request->id;
        $district = District::where("matp", $id)->get();
        if ($district->isEmpty()) {
            echo "<option value=' '>Chọn quận / huyện</option>";
            return;
        }
        $optionHtml = "<option value=' '>Chọn quận / huyện</option>";
        if (!empty($district)) {
            foreach ($district as $item) {
                $optionHtml .= "<option data-id='{$item->maqh}'
                 value='{$item->name}'>{$item->name}</option>";
            }
        }
        echo $optionHtml;
    }
    function getWard(Request $request)
    {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $ward = Ward::where("maqh", $id)->get();
        if ($ward->isEmpty()) {
            echo "<option value=' '>Chọn phường / xã</option>";
            return;
        }
        $optionHtml = "<option value=' '>Chọn phường / xã</option>";
        if (!empty($ward)) {
            foreach ($ward as $item) {
                $optionHtml .= "<option  value='{$item->name}'>{$item->name}</option>";
            }
        }
        echo $optionHtml;
    }
}
