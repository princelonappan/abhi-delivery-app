<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['title', 'description', 'price_per_unit', 'price_per_palet', 'unit', 'qty', 'category_id'];

    public function items()
    {
    	return $this->hasMany('App\CartItem');
    }

    public function images()
    {
    	return $this->hasMany('App\ProductImage');
    }

    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}