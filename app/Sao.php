<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sao extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'product_id', 'sosao'
        
    ];
    protected $primaryKey = 'id';
 	protected $table = 't_danhgiasao';
}
