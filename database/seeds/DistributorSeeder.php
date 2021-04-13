<?php

use Illuminate\Database\Seeder;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Distributor', 10)->create()->each(function($distributor){
        	$user = factory(App\User::class)->create([
    			'userable_id' => $distributor->id, 
    			'userable_type' => 'distributor'
			]);
        });
    }
}
