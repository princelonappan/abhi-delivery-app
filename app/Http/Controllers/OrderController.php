<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\Address;
use App\Settings;
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
        $cart = Cart::find(request('cart_id'))->load('items');
        $val = Settings::where('slug', 'vat')->first();
        $delivery_charge = Settings::where('slug', 'delivery_charge')->first();
        $order = Order::create([
            'customer_id' => $cart->customer_id,
            'order_total' => request('order_total'),
            'product_total' => request('product_total'),
            'delivery_charge' => request('delivery_charge'),
            'delivery_charge_percentage' => $delivery_charge->amount,
            'delivery_charge_min_amount' => $delivery_charge->min_amount,
            'vat' => request('vat'),
            'vat_percentage' => !empty($val) ? $val->amount : 0,
            'payment_type' => request('payment_type')
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
        return Order::findOrFail($id)->load('items', 'items.product', 'items.product.images');
    }
}
