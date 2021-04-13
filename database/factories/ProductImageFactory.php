<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductImage;
use Faker\Generator as Faker;

$factory->define(ProductImage::class, function (Faker $faker) {
    return [
        'product_id' => 'factory:App\Product',
        'image_name' => $faker->image($dir = '/tmp', $width = 640, $height = 480),
        'image_url' => $faker->imageUrl($width = 640, $height = 480) 
    ];
});
