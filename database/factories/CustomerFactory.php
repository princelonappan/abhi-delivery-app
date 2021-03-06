<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName." ".$faker->lastName,
        'phone_number' => $faker->tollFreePhoneNumber,
        'date_of_birth' => $faker->date('Y-m-d'),
        'status' => 'Active'
    ];
});
