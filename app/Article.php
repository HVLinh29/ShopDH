<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $timestamps = false;
    protected $fillable = ['article_name','article_desc','article_slug','article_status'];
    protected $primaryKey = 'article_id';
    protected $table = 't_article_cate';

    public function post(){
        $this->hasMany('App\Baiviet');
    }
}

