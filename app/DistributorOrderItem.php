<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorOrderItem extends Model
{
    protected $fillable = ['distributor_order_id', 'product_id', 'qty', 'price'];

    public function order()
    {
    	return $this->belongsTo('App\DistributorOrder');
    }

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
