<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false; 
    protected $fillable = [
    	'customer_id', 's_id', 'order_status','order_code','created_at','order_date'
    ];
    protected $primaryKey = 'order_id';
 	protected $table = 'tbl_order';

   
}
