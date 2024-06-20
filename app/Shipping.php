<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false; 
    protected $fillable = [
    	's_name', 's_address', 's_phone','s_email','s_notes','s_method'
    ];
    protected $primaryKey = 's_id';
 	protected $table = 't_shipping';
}
