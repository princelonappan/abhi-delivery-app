<?php

use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Cart::class, 10)->create()->each(function($cart){
        	$cart->items()->save(factory(App\CartItem::class)->make(['product_id' => factory('App\Product')->create()->id]));
        });
    }
}
