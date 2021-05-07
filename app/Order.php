<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderItem;
use App\Address;

class Order extends Model
{
	protected $fillable = ['customer_id', 'status', 'order_total', 'product_total', 'delivery_charge', 'delivery_charge_percentage', 'delivery_charge_min_amount', 'vat', 'vat_percentage', 'payment_type'];

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function items()
    {
    	return $this->hasMany('App\OrderItem');
    }

    public function address()
    {
    	return $this->morphOne('App\Address', 'addressable');
    }

    public function createOrderItems($cart)
    {
    	foreach ($cart->items as $key => $item) {
    		OrderItem::create([
    			'order_id' => $this->id,
    			'product_id' => $item->product_id,
    			'qty' => $item->qty,
    			'price' => $item->price
    		]);
    	}
    }

    public function addAddress($address)
    {
    	$address['addressable_type'] = 'order';
    	$address['addressable_id'] = $this->id;
    	$address['address_type'] = 'primary';
    	Address::create($address);
    }
}
