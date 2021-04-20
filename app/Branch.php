<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $fillable = [
        'branch_name', 'distributor_id', 'phone_number', 'status'
    ];

    public function user()
    {
    	return $this->morphOne('App\User', 'userable');		
    }

    public function address() 
    {
        return $this->morphOne('App\Address', 'addressable');		
    }
}
