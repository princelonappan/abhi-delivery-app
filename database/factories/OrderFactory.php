<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
	$customer = factory('App\Customer')->create();
	$user = factory('App\User')->create([
		'userable_type' => 'customer', 
		'userable_id' => $customer->id
	]);
    return [
        'customer_id' => $customer->id,
        'order_total' => $faker->randomFloat(NULL, 1, 1000),
        'status' => $faker->numberBetween(1,2,3)
    ];
});
