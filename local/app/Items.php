<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'tbl_items';
    protected $primaryKey = 'item_id';
    protected $guarded = ['item_id'];
    public $timestamps = false;
}
