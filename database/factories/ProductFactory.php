<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->randomFloat(NULL,1,1000),
        'unit' => 1,
        'qty' => $faker->randomDigitNotNull
    ];
});
