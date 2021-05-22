<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaletInventory;
use App\Product;
use App\DistributorOrder;
use App\Distributor;
use Illuminate\Support\Facades\Response;


class DistributorOrderController extends Controller
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
        $dis_id = $request->distributor_id;
        // dd($request->all());
        if(!empty($dis_id)) {
            $status = $request->status;
            if ($request->wantsJson) {
                $orders = DistributorOrder::where('distributor_id', $dis_id)->get();
                return $orders;
            } else {
                $orders = DistributorOrder::where('distributor_id', $dis_id)->orderBy('id', 'desc');
                if(!empty($status)) {
                    $orders = $orders->where('status', $status);
                }
                $orders = $orders->paginate(10);
                return view('admin.distributor.order.list-order')->with(['orders' => $orders, 'status' => $status]);
            }
        }

        return redirect('/admin/distributor')->with('success', 'Invalid Distributor!');

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
        $order = DistributorOrder::find($id);
        $items = $order->items;
        // $customer = Customer::find($order->customer_id);
        // print_r($order->customer->user);
        // exit;
        return view('admin.distributor.order.show-order', compact('order', 'items'));
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
        $dis_id = $request->distributor_id;
        $order = DistributorOrder::find($id);
        $order->status =  $request->get('status');
        $order->save();
        // $url = '/admin/distributor-order?=distributor_id='.$dis_id;
        return redirect('/admin/distributor')->with('success', 'Order Updated!');
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
