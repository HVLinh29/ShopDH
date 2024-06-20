<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Momo extends Model
{
    public $timestamps = false;
    protected $fillable = ['partnerCode','orderId','requestId','amount','orderInfo','resultCode','transId','message'];
    protected $primaryKey = 'id';
    protected $table = 'momo';
}
