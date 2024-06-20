<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
use Toastr;
session_start();

use Auth;
use App\Baiviet;
use App\Article;
use App\Slider;

class PostController extends Controller
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
    public function add_post()
    {
        $this->AuthLogin();
        $cate_post = Article::orderBy('article_id', 'DESC')->get();


        return view('admin.post.add_post')->with(compact('cate_post'));
    }
    public function save_post(Request $request)
    {
        $this->AuthLogin();
        $data = $request->all();
        $baiviet = new Baiviet();
        $baiviet->baiviet_title = $data['baiviet_title'];
        $baiviet->baiviet_desc = $data['baiviet_desc'];
        $baiviet->baiviet_content = $data['baiviet_content'];
        $baiviet->baiviet_meta_desc = $data['baiviet_meta_desc'];
        $baiviet->baiviet_meta_keywords = $data['baiviet_meta_keywords'];
        $baiviet->article_id = $data['article_id'];
        $baiviet->baiviet_slug = $data['baiviet_slug'];
        $baiviet->baiviet_status = $data['baiviet_status'];

        $get_image = $request->file('baiviet_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); // lay ten cua hinh anh do
            $name_imgae = current(explode('.', $get_name_image));
            $new_image = $name_imgae . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/post', $new_image);

            $baiviet->baiviet_image = $new_image;

            $baiviet->save();
            Toastr::success('Thêm bài viết thành công', 'Thành công');
            // Session::put('message', 'Thêm bai viet thành công');
            return redirect('/list-post');
        } else {
            Toastr::success('Bạn hãy thêm hình ảnh cho bài viết', 'Bạn hãy thêm hình ảnh');
            // Session::put('message', 'Ban hay them hinh anh cho bai viet');
            return redirect('/list-post');
        }
    }
    public function list_post()
    {
        $this->AuthLogin();
        $all_post = Baiviet::with('cate_post')->orderBy('id_baiviet')->get();

        return view('admin.post.list_post')->with(compact('all_post', $all_post));
    }
    public function delete_post($post_id)
    {
        $baiviet = Baiviet::find($post_id);
        $baiviet_image = $baiviet->baiviet_image;
        if ($baiviet_image) {
            $path = 'public/uploads/post/' . $baiviet_image;
            unlink($path);
        }
        $baiviet->delete();
        Toastr::error('Xóa bài viết thành công', 'Thành công');
        return redirect('/list-post');
    }
    public function edit_post($id_baiviet)
    {
        $cate_post = Article::orderBy('article_id')->get();
        $baivietbv = Baiviet::find($id_baiviet);
        return view('admin.post.edit_post')->with(compact('baivietbv', 'cate_post'));
    }
    public function update_post(Request $request, $id_baiviet)
    {
        $this->AuthLogin();
        $data = $request->all();
        $baivietbv = Baiviet::find($id_baiviet);
        $baivietbv->baiviet_title = $data['baiviet_title'];
        $baivietbv->baiviet_desc = $data['baiviet_desc'];
        $baivietbv->baiviet_content = $data['baiviet_content'];
        $baivietbv->baiviet_meta_desc = $data['baiviet_meta_desc'];
        $baivietbv->baiviet_meta_keywords = $data['baiviet_meta_keywords'];
        $baivietbv->article_id = $data['article_id'];
        $baivietbv->baiviet_slug = $data['baiviet_slug'];
        $baivietbv->baiviet_status = $data['baiviet_status'];

        $get_image = $request->file('baiviet_image');
        if ($get_image) {
            //Xoa anh cu
            $baiviet_image_old = $baivietbv->baiviet_image;
            $path = 'public/uploads/post/' . $baiviet_image_old;
            unlink($path);
            //Cap nhat anh moi
            $get_name_image = $get_image->getClientOriginalName(); // lay ten cua hinh anh do
            $name_imgae = current(explode('.', $get_name_image));// lay ten truoc dau cham
            $new_image = $name_imgae . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/post', $new_image);

            $baivietbv->baiviet_image = $new_image;
        }

        $baivietbv->save();
        Toastr::success('Cập nhật bài viết thành công', 'Thành công');
        return redirect('/list-post');
    }
    public function danh_muc_bai_viet(Request $request, $baiviet_slug)
    {
        $category_post = Article::orderBy('article_id', 'DESC')->get();

        $slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();

        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

        $catepost = Article::where('article_slug', $baiviet_slug)->take(1)->get();// tim cai danh muc bai viet dua tren slug 

        foreach ($catepost as $key => $cate) {
            $meta_desc = $cate->article_desc;
            $meta_keywords = $cate->article_slug;
            $meta_title = $cate->article_name;
            $cate_id = $cate->article_id;
            $url_canonical = $request->url();
        }

        $baiviett = Baiviet::with('cate_post')->where('baiviet_status', 1)->where('article_id', $cate_id)->get();// tim cac bai viet lien quan dua tren danh muc cua no


        return view('pages.baiviet.danhmucbaiviet')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post)
            ->with('baiviett', $baiviett);
    }
    public function bai_viet(Request $request, $baiviet_slug)
    {
        $category_post = Article::orderBy('article_id', 'DESC')->get();

        $slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();

        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 
       
        $baiviett = Baiviet::with('cate_post')->where('baiviet_status', 1)->where('baiviet_slug', $baiviet_slug)->take(1)->get();
        foreach ($baiviett as $key => $p) {
            $meta_desc = $p->baiviet_meta_desc;
            $meta_keywords = $p->baiviet_meta_keywords;
            $meta_title = $p->baiviet_title;
            $cate_id = $p->article_id;
            $url_canonical = $request->url();
            $article_id = $p->article_id;
            $id_baiviet = $p->id_baiviet;
        }

        //update view 
        $baiviet = Baiviet::where('id_baiviet', $id_baiviet)->first();
        $baiviet->baiviet_view = $baiviet->baiviet_view + 1;
        $baiviet->save();

        $related = Baiviet::with('cate_post')->where('baiviet_status', 1)->where('article_id', $article_id)
            ->whereNotIn('baiviet_slug', [$baiviet_slug])->take(5)->get();

        return view('pages.baiviet.baiviet')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post)
            ->with('baiviett', $baiviett)->with('related', $related);
    }
}
