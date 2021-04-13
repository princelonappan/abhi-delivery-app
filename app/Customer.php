<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function carts()
    {
    	return $this->hasMany('App\Cart');
    }

    public function orders()
    {
    	return $this->hasMany('App\Order');
    }

    public function addresses()
    {
    	return $this->morphMany('App\Address', 'addressable');	
    }

    public function user()
    {
    	return $this->morphOne('App\User', 'userable');		
    }
}
