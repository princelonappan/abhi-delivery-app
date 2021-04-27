<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\Address;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('customer_id', request('customer_id'))->get();
        return $orders->load('items');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        //print_r($request->only((new Address)->attributes));exit;
        $cart = Cart::find(request('cart_id'))->load('items');
        $order = Order::create([
            'customer_id' => $cart->customer_id,
            'order_total' => request('order_total') 
        ]);
        $order->createOrderItems($cart);
        $order->address()->create($request->except(['cart_id', 'order_total']));
        $cart->update(['status' => 'Checked Out']);

        return $order->load('items');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::findOrFail($id)->load('items');
    }
}
