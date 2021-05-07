<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Distributor;
use App\User;
use App\Customer;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * show dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = Customer::where('status', 'Active')->count();
        $distributors = Distributor::where('status', 1)->count();
        $products = Product::where('status', 1)->count();
        $orders = Order::where('status', '!=', 'Canceled')->count();
        return view('admin.dashboard.index', compact('customers', 'distributors', 'orders', 'products'));
    }

}
