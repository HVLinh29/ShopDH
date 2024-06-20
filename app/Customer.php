<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false; 
    protected $fillable = [
    	'customer_name', 'email', 'password','phone','customer_vip',
    ];
    protected $primaryKey = 'customer_id';
 	protected $table = 't_customer';
}
