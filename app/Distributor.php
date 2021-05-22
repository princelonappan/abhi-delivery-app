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

    public function carts()
    {
        return $this->hasMany('App\DistributorCart');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function addresses()
    {
        return $this->morphMany('App\Address', 'addressable');
    }
}
