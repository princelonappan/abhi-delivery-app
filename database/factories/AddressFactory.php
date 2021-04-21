<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    $customer = factory('App\Customer')->create();
    return [
    	'addressable_id' => $customer->id,
    	'addressable_type' => 'customer',
    	'address_type' => 'primary',
        'address' => $faker->streetAddress,
        'address2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'country' => $faker->country
    ];
});
