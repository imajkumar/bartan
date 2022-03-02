<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = 'tbl_item_category';
    protected $guarded = [''];
    public $timestamps = false;
}
