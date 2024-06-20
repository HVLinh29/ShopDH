<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false;
    protected $fillable = ['tenthuonghieu','thuonghieu_desc','thuonghieu_status','thuonghieu_slug'];
    protected $primaryKey = 'brand_id';
    protected $table = 't_thuonghieu';

    
}
