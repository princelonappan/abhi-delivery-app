<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Requests\CartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts =  Cart::where('customer_id', request('customer_id'))->get();
        return $carts->load('customer', 'items', 'items.product',  'items.product.category', 'items.product.images');
    }

    public function store(CartRequest $request)
    {
        $cart = Cart::where(['customer_id' => request('customer_id'), 'status' => 'Active'])->first();
        if(empty($cart)) {
            $cart = Cart::create([
                'customer_id' => request('customer_id'),
                'status' => 'Active'
            ]);
        }
        if($request->has('product_id')) {
            $cart->addCustomerItem(request('product_id'), request('qty'), request('price'));
        }
        return $cart->load('customer', 'items', 'items.product', 'items.product.category');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cart::findOrFail($id)->load('customer', 'items', 'items.product', 'items.product.category');
    }

    public function update(CartRequest $request, $id)
    {
        $cart = Cart::findOrFail($id);
        if(request('operation') == 'Add') {
            $cart->addCustomerItem(request('product_id'), request('qty'), request('price'));
        } elseif (request('operation') == 'Update') {
            $cart->updateCustomerItem(request('product_id'), request('qty'), request('price'));
        } elseif (request('operation') == 'Delete') {
            $cart->removeCustomerItem(request('product_id'), request('qty'), request('price'));
        }
        return $cart->load('customer', 'items', 'items.product', 'items.product.category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
