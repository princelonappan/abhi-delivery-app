<?php

namespace App\Http\Controllers;

use App\Order;
use App\Cart;
use App\Address;
use App\Settings;
use App\PaymentTransaction;
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
        $orders = Order::where('customer_id', request('customer_id'))->orderBy('created_at', 'desc')->get();
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
        if(empty(request('payment_type')) && request('payment_type') == 2) {
            if(!empty(request('transaction_id'))) {
                $responseArray['message'] = 'Invalid Transactions';
                $responseArray['success'] = false;
                return response()->json($responseArray, 500);
            }
        }
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

        if(request('payment_type') == 2 && !empty(request('transaction_id'))) {
            $transcation = PaymentTransaction::where('payment_transaction_id', request('transaction_id'))->first();
            $transcation->order_id = $order->id;
            $transcation->save();
        } else {
            $responseArray['message'] = 'Invalid Transactions';
            $responseArray['success'] = false;
            return response()->json($responseArray, 500);
        }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelOrder(OrderRequest $request) {
        $order = Order::where('id', $request->id)->where('customer_id', $request->customer_id)->first();
        if(!empty($order)) {
            $order->status = "Canceled";
            $order->save();
            return Order::findOrFail($request->id)->load('items', 'items.product', 'items.product.images');
        }
        $responseArray['message'] = 'Something went wrong';
        $responseArray['success'] = false;
        return response()->json($responseArray, 500);
    }
}
