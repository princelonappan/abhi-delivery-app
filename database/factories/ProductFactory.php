<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
	$category = factory('App\Category')->create();
    return [
        'title' => $faker->word,
        'description' => $faker->sentence,
        'price_per_unit' => $faker->randomFloat(NULL,1,1000),
        'price_per_palet' => $faker->randomFloat(NULL,1,1000),
        'unit' => 1,
        'qty' => $faker->randomDigitNotNull,
        'category_id' => $category->id
    ];
});
