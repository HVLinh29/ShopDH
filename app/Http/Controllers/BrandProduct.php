<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use App\Brand;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Article;
use App\Slider;
use Auth;
use Toastr;
class BrandProduct extends Controller
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

    public function add_brand_product(){
        $this->AuthLogin();
        return view('admin.brand.add_brand_product');
    }
    public function all_brand_product(){
        $this->AuthLogin();
        $all_brand_product = Brand::orderBy('brand_id','DESC')->get();
        $manager_brand_product = view('admin.brand.all_brand_product')->with('all_brand_product',$all_brand_product);
        return view('admin_layout')->with('admin.brand.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $this->AuthLogin();
        $data = $request->all();
        $brand = new Brand();
        $brand->tenthuonghieu =$data['tenthuonghieu'];
        $brand->thuonghieu_slug =$data['thuonghieu_slug'];
        $brand->thuonghieu_desc =$data['thuonghieu_desc'];
        $brand->thuonghieu_status =$data['thuonghieu_status'];
        $brand->save();
        Toastr::success('Thêm thương hiệu sản phẩm thành công', 'Thành công');
        return Redirect::to('all-brand-product');

    }
    public function unactive_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('t_thuonghieu')->where('brand_id',$brand_product_id)->update(['thuonghieu_status'=>1]);
        Toastr::error('Hủy kích hoạt được thương hiệu sản phẩm', 'Hủy thành công');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('t_thuonghieu')->where('brand_id',$brand_product_id)->update(['thuonghieu_status'=>0]);
        Toastr::success('Kích hoạt thương hiệu sản phẩm thành công', 'Thành công');
       
        return Redirect::to('all-brand-product');
    }
    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();
        $edit_brand_product= Brand::where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.brand.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request,$brand_product_id){
        $this->AuthLogin();
       
        $data = $request->all();
        $brand = Brand::find($brand_product_id);// truy xuat 1 ban ghi
        $brand->tenthuonghieu =$data['tenthuonghieu'];
        $brand->thuonghieu_slug =$data['thuonghieu_slug'];
        $brand->thuonghieu_desc =$data['thuonghieu_desc'];
        $brand->save();
        Toastr::success('Cập nhật thương hiệu sản phẩm thành công', 'Thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();
        DB::table('t_thuonghieu')->where('brand_id',$brand_product_id)->delete();
        Toastr::error('Xóa thương hiệu sản phẩm thành công', 'Thành công');
        return Redirect::to('all-brand-product');
    }

    //Trang chu Fontend
    public function show_brand_home(Request $request, $brand_slug){
        $category_post = Article::orderBy('article_id', 'DESC')->get();
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 
        
        
        $brand_by_id = DB::table('tbl_product')->join('t_thuonghieu','tbl_product.brand_id','=','t_thuonghieu.brand_id')->where('t_thuonghieu.thuonghieu_slug',$brand_slug)->paginate(6);

        $brand_name = DB::table('t_thuonghieu')->where('t_thuonghieu.thuonghieu_slug',$brand_slug)->limit(1)->get();

        foreach($brand_name as $key => $val){
            //seo 
            $meta_desc = $val->thuonghieu_desc; 
            $meta_keywords = $val->thuonghieu_desc;
            $meta_title = $val->tenthuonghieu;
            $url_canonical = $request->url();
            //--seo
        }
         
        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)->with('meta_desc',$meta_desc)
        ->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
        ->with('slider',$slider) ->with('category_post',$category_post);
    }
}
