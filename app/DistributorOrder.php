<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorOrder extends Model
{
    protected $fillable = ['distributor_id', 'order_no', 'status', 'palet_order_total', 'product_total', 'delivery_charge', 'delivery_charge_percentage', 'delivery_charge_min_amount', 'vat', 'vat_percentage', 'payment_type'];

    public function distributor()
    {
    	return $this->belongsTo('App\Distributor');
    }

    public function items()
    {
    	return $this->hasMany('App\DistributorOrderItem');
    }

    public function address()
    {
    	return $this->morphOne('App\Address', 'addressable');
    }

    public function createOrderItems($cart)
    {
    	foreach ($cart->items as $key => $item) {
    		DistributorOrderItem::create([
    			'distributor_order_id' => $this->id,
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
