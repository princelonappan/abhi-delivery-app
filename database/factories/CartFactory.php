<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cart;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
	$customer = factory('App\Customer')->create();
	$user = factory('App\User')->create([
		'userable_type' => 'customer', 
		'userable_id' => $customer->id
	]);
    return [
        'customer_id' => $customer->id,
        'status' => 'Active'
    ];
});
