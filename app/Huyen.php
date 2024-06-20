<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Huyen extends Model
{
    public $timestamps = false;
    protected $fillable = ['tenhuyen','type','matinh'];
    protected $primaryKey = 'mahuyen';
    protected $table = 't_huyen';
}
