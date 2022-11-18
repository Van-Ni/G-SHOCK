<?php

namespace App\Http\Controllers;

use App\User;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('verified');
        $this->middleware(function ($request, $next) {
            session(["module_active" => 'dashboard']);
            return $next($request);
        });
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        App::setLocale("en");
        $countOrderDone = Order::where('status', '3')->count();
        $countOrderPending = Order::where('status', '1')->count();
        $countOrderTrash = Order::where('status', '0')->count();
        $ourSale = Order::selectRaw('SUM(total_price) as total_sale')->get();
        $counts = [
            $countOrderDone, $countOrderPending,
            $countOrderTrash
        ];
        $orders = Order::select('orders.*', 'customers.customer_name', "customers.phone_number")
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->orderBy('created_at',"desc")
            ->paginate(10);
            return view('admin.dashboard', compact('counts', 'ourSale','orders'));
        // if(Gate::allows('is-admin')){
        // }else{
        //     abort(403);
        // }
    }
}
