<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;

use App\Exports\ExcelExports;
use Excel;
use App\Imports\Imports;
use App\CategoryModel;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Article;
use Auth;
use Toastr;
class CategoryPost extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Auth::id();
    
        if ($admin_id) {
            return Redirect::to('admin.dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_category_post(){
        $this->AuthLogin();
        return view('admin.category_post.add_cate_post');
    }
    public function save_category_post(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        
        $category_post = new Article();
        $category_post->article_name = $data['article_name'];
        $category_post->article_desc = $data['article_desc'];
        $category_post->article_status = $data['article_status'];
        $category_post->article_slug = $data['article_slug'];
      
        $category_post->save();
        Toastr::success('Thêm danh mục bài viết thành công', 'Thành công');
        // Session::put('message','Thêm danh mục bai viet thành công');
        return redirect('/list-category-post');

    }
    public function list_category_post(){
        $this->AuthLogin();
        $category_post = Article::orderBy('article_id','DESC')->get();
       
        return view('admin.category_post.list_category_post')->with(compact('category_post'));
    }
    
    public function edit_category_post($article_id){
        $this->AuthLogin();
        $category_post = Article::find($article_id);
       
        return view('admin.category_post.edit_cate_post')->with(compact('category_post'));
    }
    public function update_category_post(Request $request,$cate_id){
        
        $data = $request->all();
        $category_post = Article::find($cate_id);
      
        $category_post->article_name = $data['article_name'];
        $category_post->article_desc = $data['article_desc'];
        $category_post->article_status = $data['article_status'];
        $category_post->article_slug = $data['article_slug'];
      
        $category_post->save();
        Toastr::success('Cập nhật danh mục bài viết thành công', 'Thành công');
        // Session::put('message','Cap nhat danh mục bai viet thành công');
        return redirect('/list-category-post');
    }
    public function delete_category_post($cate_id){
        $category_post = Article::find($cate_id);
        $category_post->delete();
        Toastr::error('Xóa danh mục bài viết thành công', 'Thành công');
        // Session::put('message','Xóa danh mục bai viet thành công');
        return redirect('/list-category-post');
    }
}
