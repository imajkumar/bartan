<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itemOrderProcess extends Model
{
    protected $table = 'item_order_packing_details'; 
    protected $guarded = ['id'];
    public $timestamps = true;
    
}
