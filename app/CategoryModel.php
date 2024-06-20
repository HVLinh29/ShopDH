<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['tendanhmuc','danhmuc_slug','meta_keywords','danhmuc_status','danhmuc_desc',];
    protected $primaryKey = 'category_id';
    protected $table = 't_danhmucsanpham';

    public function product(){
        return $this->hasMany('App\Product');
    }
}
