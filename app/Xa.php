<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xa extends Model
{
    public $timestamps = false;
    protected $fillable = ['tenxa','type','mahuyen'];
    protected $primaryKey = 'maxa';
    protected $table = 't_xa';
}
