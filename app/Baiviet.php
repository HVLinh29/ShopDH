<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Baiviet extends Model
{
    public $timestamps = false;
    protected $fillable = ['baiviet_title','baiviet_desc','baiviet_content','baiviet_meta_desc','baiviet_keywords','baiviet_status',
    'baiviet_image','baiviet_id','baiviet_slug','baiviet_view'];
    protected $primaryKey = 'id_baiviet';
    protected $table = 't_baiviet';

    public function cate_post(){
        return $this->belongsTo('App\Article','article_id');
    }
}
