<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function items()
    {
    	return $this->hasMany('App\CartItem');
    }

    public function images()
    {
    	return $this->hasMany('App\ProductImage');
    }
}
