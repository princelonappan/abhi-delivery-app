<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CartItem;
use Faker\Generator as Faker;

$factory->define(CartItem::class, function (Faker $faker) {
    return [
        'cart_id' => 'factory:App\Cart',
        'status' => $faker->numberBetween(1,2,3),
        'product_id' => 'factory:App\Product',
        'qty' =>  $faker->randomDigitNotNull,
        'price' => $faker->randomFloat(NULL, 1, 1000)
    ];
});
