<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $primaryKey = 'pizza_id';
    public $timestamps = false;


    protected $fillable = ['pizza_name','image','pizza_desc', 'price'];
}
