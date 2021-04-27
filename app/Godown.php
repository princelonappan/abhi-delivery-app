<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Godown extends Model
{
    protected $table = 'godown';

    protected $fillable = [
        'name', 'godown_unique_id', 'details', 'latitude', 'longitude', 'address'
    ];

}
