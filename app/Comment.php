<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;
    protected $fillable = ['cmt','cmt_name','cmt_date','cmt_product_id'];
    protected $primaryKey = 'cmt_id';
    protected $table = 't_comment';


    public function product(){
       return $this->belongsTo('App\Product','cmt_pr_id');
    }
}
