<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DistributorCart extends Model
{
    protected $fillable = ['distributor_id', 'status'];

    public function distributor()
    {
    	return $this->belongsTo('App\Distributor');
    }

    public function items()
    {
    	return $this->hasMany('App\DistributorCartItem');
    }

    public function orders()
    {
    	return $this->hasMany('App\Order');
    }

    public function addDistributorItem($productId, $quantity=1, $price)
    {
        if(!$this->items()->where(['distributor_cart_id' => $this->id, 'product_id' => $productId])->exists()) {
            $this->items()->create([
                'product_id' => $productId,
                'qty' => $quantity,
                'price' => $price*$quantity,
            ]);
        }
    }

    public function updateDistributorItem($productId, $quantity=1, $price)
    {
        if(!empty($quantity)) {
            if($this->items()->where(['distributor_cart_id' => $this->id, 'product_id' => $productId])->exists()) {
                $this->items()->where('product_id', $productId)->update([
                    'qty' => $quantity,
                    'price' => $price*$quantity
                ]);
            }
        } else {
            $this->items()->where(['distributor_cart_id' => $this->id, 'product_id' => $productId])->delete();

            $cart_count = $this->items()->where(['distributor_cart_id' => $this->id])->count();

            if($cart_count == 0) {
                $this->delete();
            }
        }

    }

    public function removeDistributorItem($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
    }
}
