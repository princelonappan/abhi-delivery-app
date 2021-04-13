<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function items()
    {
    	return $this->hasMany('App\CartItem');
    }

    public function orders()
    {
    	return $this->hasMany('App\Order');
    }
}
