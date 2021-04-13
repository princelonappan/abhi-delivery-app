<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'order_id' => 'factory:App\Order',
        'product_id' => 'factory:App\Product',
        'qty' =>  $faker->randomDigitNotNull,
        'price' => $faker->randomFloat(NULL, 1, 1000)
    ];
});
