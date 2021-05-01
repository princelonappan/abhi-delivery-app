<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = ['customer_id', 'status'];

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

    public function addCustomerItem($productId, $quantity=1, $price)
    {
        if(!$this->items()->where(['cart_id' => $this->id, 'product_id' => $productId])->exists()) {
            $this->items()->create([
                'product_id' => $productId,
                'qty' => $quantity,
                'price' => $price*$quantity,
            ]);
        }
    }

    public function updateCustomerItem($productId, $quantity=1, $price)
    {
        if(!empty($quantity)) {
            if($this->items()->where(['cart_id' => $this->id, 'product_id' => $productId])->exists()) {
                $this->items()->where('product_id', $productId)->update([
                    'qty' => $quantity,
                    'price' => $price*$quantity
                ]);
            }
        } else {
            $this->items()->where(['cart_id' => $this->id, 'product_id' => $productId])->delete();
        }
        $cart_count = $this->items()->where(['cart_id' => $this->id])->count();

        if(empty($cart_count)) {
            $this->delete();
        }
    }

    public function removeCustomerItem($productId)
    {
        $this->items()->where('product_id', $productId)->delete();
    }
}
