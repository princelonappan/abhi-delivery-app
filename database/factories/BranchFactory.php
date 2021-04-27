<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
	$distributor = factory('App\Distributor')->create();
	$user = factory('App\User')->create([
		'userable_type' => 'distributor', 
		'userable_id' => $distributor->id
	]);
    return [
        'branch_name' => $faker->word,
        'distributor_id' => $distributor->id,
        'status' => 'Active',
        'phone_number' => $faker->tollFreePhoneNumber
    ];
});
