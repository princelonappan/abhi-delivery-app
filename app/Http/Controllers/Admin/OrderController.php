<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaletInventory;
use App\Product;
use App\Order;
use App\Customer;
use Illuminate\Support\Facades\Response;


class OrderController extends Controller
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
        $status = $request->status;
        if ($request->wantsJson) {
            $orders = Order::all();
            return $orders;
        } else {
            $orders = Order::orderBy('id', 'desc');
            if(!empty($status)) {
                $orders = $orders->where('status', $status);
            }
            $orders = $orders->paginate(10);
            return view('admin.order.list-order')->with(['orders' => $orders, 'status' => $status]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.distributor.add-distributor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        $items = $order->items;
        // $customer = Customer::find($order->customer_id);
        // print_r($order->customer->user);
        // exit;
        return view('admin.order.show-order', compact('order', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $order = Order::find($id);
        $order->status =  $request->get('status');
        $order->save();

        return redirect('/admin/order')->with('success', 'Order Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
