<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    public $timestamps = false;
    protected $fillable = ['g_name','g_image','product_id'];
    protected $primaryKey = 'g_id';
    protected $table = 't_gallery';

}
