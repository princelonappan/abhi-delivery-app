<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Settings;
use App\CartItem;
use App\Http\Requests\CartRequest;

class CartV2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $carts =  Cart::where('customer_id', request('customer_id'))->where('status', 'Active')->first();
        if(!empty($carts)) {
            $data['cart'] = $carts->load('customer', 'items', 'items.product',  'items.product.category', 'items.product.images');
            $vat = Settings::where('slug', 'vat')->first();
            $vat_persantage = !empty($vat->amount) ? $vat->amount : 0;
            $product_total = 0;
            foreach($data['cart']->items as $item) {
                $product_total+=$item->price;
            }
            // $vat_amount = (!empty($vat_persantage) && !empty($product_total)) ? $product_total/$vat_persantage : 0;
            $vat_amount = (!empty($vat_persantage) && !empty($product_total)) ? ($vat_persantage/100)*$product_total : 0;
            $delivery = $vat = Settings::where('slug', 'delivery_charge')->first();
            $delivery_charge = 0;

            // $delivery_charge = !empty($delivery) ? (($delivery->min_amount > $product_total) ? $delivery->min_amount : 0)  : 0;
            $delivery_charge = !empty($delivery) ? (($delivery->min_amount > $product_total) ? $delivery->amount : 0)  : 0;
            $is_payment_mode = Settings::where('slug', 'payment_mode')->first();

            $data['product_total'] = $product_total;
            $data['vat'] = $vat_amount;
            $data['delivery_charge'] = $delivery_charge;
            $data['total_amount'] = $delivery_charge+$vat_amount+$product_total;
            $data['payment_type']['cash_on_delivery']['status'] = (!empty($is_payment_mode) && $is_payment_mode->cash_on_delivery == 1)? true : false;
            $data['payment_type']['cash_on_delivery']['code'] = 1;
            $data['payment_type']['card_payment']['status'] = (!empty($is_payment_mode) && $is_payment_mode->card_payment == 1)? true : false;
            $data['payment_type']['card_payment']['code'] = 2;
            return $data;
        } else {
            $data = null;
            return $data;
        }

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
            $cart_item = CartItem::where('cart_id', $cart->id)->where('product_id', request('product_id'))->first();
            if(!empty($cart_item)) {
                $cart_item->qty = $cart_item->qty+request('qty');
                $cart_item->price = $cart_item->qty*request('price');
                $cart_item->save();

            } else {
                $cart->addCustomerItem(request('product_id'), request('qty'), request('price'));
            }
        }

        $data = [];
        $cart =  Cart::where('customer_id', request('customer_id'))->where('status', 'Active')->first();
        if(!empty($cart)) {
            $data['cart'] = $cart->load('customer', 'items', 'items.product',  'items.product.category', 'items.product.images');
            $vat = Settings::where('slug', 'vat')->first();
            $vat_persantage = !empty($vat->amount) ? $vat->amount : 0;
            $product_total = 0;
            foreach($data['cart']->items as $item) {
                $product_total+=$item->price;
            }
            // $vat_amount = (!empty($vat_persantage) && !empty($product_total)) ? $product_total/$vat_persantage : 0;
            $vat_amount = (!empty($vat_persantage) && !empty($product_total)) ? ($vat_persantage/100)*$product_total : 0;
            $delivery = $vat = Settings::where('slug', 'delivery_charge')->first();
            $delivery_charge = 0;

            $delivery_charge = !empty($delivery) ? (($delivery->min_amount > $product_total) ? $delivery->amount : 0)  : 0;
            $is_payment_mode = Settings::where('slug', 'payment_mode')->first();

            $data['product_total'] = $product_total;
            $data['vat'] = $vat_amount;
            $data['delivery_charge'] = $delivery_charge;
            $data['total_amount'] = $delivery_charge+$vat_amount+$product_total;
            $data['settings']['cash_on_delivery'] = (!empty($is_payment_mode) && $is_payment_mode->cash_on_delivery == 1)? true : false;
            $data['settings']['card_payment'] = (!empty($is_payment_mode) && $is_payment_mode->card_payment == 1)? true : false;
            return $data;
        } else {
            $data = null;
            return $data;
        }

        // return $cart->load('customer', 'items', 'items.product', 'items.product.category');
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
        $carts = Cart::where('id', $id)->first();

        if(!empty($carts)) {
            $data['cart'] = $carts->load('customer', 'items', 'items.product',  'items.product.category', 'items.product.images');
            $vat = Settings::where('slug', 'vat')->first();
            $vat_persantage = !empty($vat->amount) ? $vat->amount : 0;
            $product_total = 0;
            foreach($data['cart']->items as $item) {
                $product_total+=$item->price;
            }
            $vat_amount = (!empty($vat_persantage) && !empty($product_total)) ? ($vat_persantage/100)*$product_total : 0;
            $delivery = $vat = Settings::where('slug', 'delivery_charge')->first();
            $delivery_charge = 0;

            $delivery_charge = !empty($delivery) ? (($delivery->min_amount > $product_total) ? $delivery->delivery_charge : 0)  : 0;
            $is_payment_mode = Settings::where('slug', 'payment_mode')->first();

            $data['product_total'] = $product_total;
            $data['vat'] = $vat_amount;
            $data['delivery_charge'] = $delivery_charge;
            $data['total_amount'] = $delivery_charge+$vat_amount+$product_total;
            $data['settings']['cash_on_delivery'] = (!empty($is_payment_mode) && $is_payment_mode->cash_on_delivery == 1)? true : false;
            $data['settings']['card_payment'] = (!empty($is_payment_mode) && $is_payment_mode->card_payment == 1)? true : false;
            return $data;
        } else {
            $data = null;
            return $data;
        }

        // return $cart->load('customer', 'items', 'items.product', 'items.product.category');
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
