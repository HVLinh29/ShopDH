<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truycap extends Model
{
    public $timestamps = false;
    protected $fillable = ['ip_address','ngaytruycap '];
    protected $primaryKey = 'id_truycap';
    protected $table = 't_truycap';
}
