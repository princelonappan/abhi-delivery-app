<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Order::class, 10)->create()->each(function($order){
        	$order->items()->save(factory(App\OrderItem::class)->make(['product_id' => factory('App\Product')->create()->id]));
        });
    }
}
