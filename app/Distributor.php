<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributors';

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'address', 'status'
    ];

    public function user()
    {
    	return $this->morphOne('App\User', 'userable');		
    }
}
