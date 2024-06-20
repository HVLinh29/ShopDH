<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thongke extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_date','gia','loinhuan','soluong','total_order'];
    protected $primaryKey = 'id_tk';
    protected $table = 't_thongke';
}
