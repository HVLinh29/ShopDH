<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginGG extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'gg_user_id',  'gg',  'user','gg_user_email'
    ];
 
    protected $primaryKey = 'id';
 	protected $table = 'tbl_social';
 	
 	public function customer(){
 		return $this->belongsTo('App\Customer', 'user');
 	}

}
