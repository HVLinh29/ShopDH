<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false;
    protected $fillable = ['mtinh','mhuyen','mxa','fee_feeship'];
    protected $primaryKey = 'fee_id';
    protected $table = 't_phiship';

    public function city(){
        return $this->belongsTo('App\Tinh', 'mtinh');
    }
    public function province(){
        return $this->belongsTo('App\Huyen', 'mhuyen');
    }
    public function wards(){
        return $this->belongsTo('App\Xa', 'mxa');
    }
}
