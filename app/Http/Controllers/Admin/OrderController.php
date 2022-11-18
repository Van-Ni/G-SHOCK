<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => 'order']);
            return $next($request);
        });
    }
    function list(Request $request)
    {
        $keyword = "";
        if ($request->keyword) {
            $keyword = $request->keyword;
        }
        $orders = Order::select('orders.*', 'customers.customer_name', "customers.phone_number")
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.order_code', 'LIKE', "%{$keyword}%")
            ->orWhere('customers.customer_name', 'LIKE', "%{$keyword}%")
            ->orderBy("orders.created_at","desc")
            ->paginate(10);
        $list_act = array(
            'delete' => "Xóa tạm thời",
        );
        $status = $request->status;
        // dd($status);
        if (isset($status)) {
            $orders = Order::select('orders.*', 'customers.customer_name', "customers.phone_number")
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('orders.status', "{$status}")
                ->where(function ($query) use ($keyword) {
                    $query->where('customers.customer_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('orders.order_code', 'LIKE', "%{$keyword}%");
                })
                ->orderBy("orders.created_at","desc")   
                ->paginate(10);
        }
        if ($status == 'trash') {
            $orders = Order::onlyTrashed()
                ->select('orders.*', 'customers.customer_name', "customers.phone_number")
                ->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where(function ($query) use ($keyword) {
                    $query->where('customers.customer_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('orders.order_code', 'LIKE', "%{$keyword}%");
                })
                ->orderBy("orders.created_at","desc")
                ->paginate(10);
            $list_act = array(
                'forceDelete' => "Xóa vĩnh viễn",
                'restore' => 'Khôi phục',
            );
        }
        $countOrder = Order::count();
        $countOrderPending = Order::where('status', '1')->count();
        $countOrderDelivery = Order::where('status', '2')->count();
        $countOrderDone = Order::where('status', '3')->count();
        $countOrderCancel = Order::where('status', '0')->count();
        $countOrderTrash = Order::onlyTrashed()->count();
        $counts = [
            $countOrder, $countOrderPending, $countOrderDelivery,
            $countOrderDone, $countOrderCancel, $countOrderTrash
        ];
        return view('admin.order.list', compact('orders', 'counts', 'list_act'));
    }
    function action(Request $request)
    {
        $action = $request->act;
        if (empty($action)) {
            return redirect('admin/order/list')->with('act_danger', 'Chưa chọn hành động');
        } else {
            $listcheck = $request->listcheck;
            if (empty($listcheck)) {
                return redirect('admin/order/list')->with('act_danger', 'Chưa chọn đơn hàng');
            } else {
                if ($action == 'delete') {
                    Order::destroy($listcheck);
                    return redirect('admin/order/list')->with('act_danger', 'Đã xóa đơn hàng thành công');
                }
                if ($action == 'forceDelete') {
                    Order::onlyTrashed()->whereIn('id', $listcheck)->forceDelete();
                    return redirect('admin/order/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn đơn hàng  thành công');
                }
                if ($action == 'restore') {
                    Order::onlyTrashed()->whereIn('id', $listcheck)->restore();
                    return redirect('admin/order/list')->with('act_success', 'Đã khôi phục đơn hàng thành công');
                }
            }
        }
    }
    function edit($id)
    {
        $order = Order::select('orders.*', "customers.*")
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('orders.id', $id)
            ->get();
        foreach ($order as $item) {
            $list_product = $item->list_product;
        }
        $list_product = json_decode($list_product, true);
        return view('admin.order.edit', compact('order', 'list_product'));
    }
    function delete($id)
    {
        $product = Order::find($id);
        $product->delete();
        return redirect('admin/order/list')->with('act_danger', 'Đã xóa đơn hàng thành công');
    }
    function forceDelete($id)
    {
        Order::onlyTrashed()->where('id', $id)->forceDelete();
        return redirect('admin/order/list?status=trash')->with('act_danger', 'Đã xóa vĩnh viễn đơn hàng thành công');
    }
    function restore($id)
    {
        Order::onlyTrashed()->where('id', $id)->restore();
        return redirect('admin/order/list?status=trash')->with('act_success', 'Đã khôi phục đơn hàng thành công');
    }
    function update(Request $request, $id)
    {
        Order::where('id', $id)->update(
            [
                'status' =>  $request->action,
            ]
        );
        return redirect("admin/order/edit/{$id}")->with('act_success', 'Đã cập nhật đơn hàng thành công');
    }
}
