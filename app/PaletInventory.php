<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaletInventory extends Model
{
    protected $table = 'palet_inventory';

    protected $fillable = [
        'godown_id', 'product_id', 'palet_id', 'available'
    ];

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }

    public function godown()
    {
    	return $this->belongsTo('App\Godown');
    }
}
