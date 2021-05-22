<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorCartItem extends Model
{
    protected $fillable = ['distributor_cart_id', 'product_id', 'qty', 'price'];

    public function cart()
    {
    	return $this->belongsTo('App\DistributorCart');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
