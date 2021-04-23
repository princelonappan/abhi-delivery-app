<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Distributor;
use Faker\Generator as Faker;

$factory->define(Distributor::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName." ".$faker->lastName,
        'phone_number' => $faker->tollFreePhoneNumber,
        'status' => 'Active'
    ];
});
