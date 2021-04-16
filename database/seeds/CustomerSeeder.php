<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Customer', 10)->create()->each(function($customer){
        	$user = factory(App\User::class)->create([
    			'userable_id' => $customer->id, 
    			'userable_type' => 'customer',
                'email' => 'customer'.time().'@gmail.com', 
                'password' => bcrypt('password')
			]);
        });
    }
}
