<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tinh extends Model
{
    public $timestamps = false;
    protected $fillable = ['tentinh','type'];
    protected $primaryKey = 'matinh';
    protected $table = 't_tinh';
}
