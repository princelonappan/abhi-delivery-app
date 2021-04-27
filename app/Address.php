<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'addressable_type', 'addressable_id', 'address_type', 'address', 'address2', 'city',
        'state', 'zip', 'country'
    ];

    public function addressable()
    {
    	return $this->morphTo();
    }
}
