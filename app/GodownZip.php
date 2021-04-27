<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GodownZip extends Model
{
    protected $table = 'godown_zip_code';

    protected $fillable = [
        'godown_id', 'zip_code'
    ];

}
