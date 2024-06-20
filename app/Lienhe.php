<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lienhe extends Model
{
    public $timestamps = false; 
    protected $fillable = [
    	'ct_map', 'ct_contact', 'ct_logo','ct_fanpage'
    ];
    protected $primaryKey = 'ct_id';
 	protected $table = 't_lienhe';
}
