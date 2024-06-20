<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $timestamps = false;
    protected $fillable = [
    	'order_code', 'product_id', 'product_name','product_price','soluong','magiamgia','phiship'
    ];
    protected $primaryKey = 'order_details_id';
 	protected $table = 't_chitietdonhang';

 	public function product(){
 		return $this->belongsTo('App\Product','product_id');
 	}
}
