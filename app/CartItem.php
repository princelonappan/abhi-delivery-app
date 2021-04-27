<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
	protected $fillable = ['cart_id', 'product_id', 'qty', 'price'];
	
    public function cart()
    {
    	return $this->belongsTo('App\Cart');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
