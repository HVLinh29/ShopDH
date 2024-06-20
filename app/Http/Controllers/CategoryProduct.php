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
use Toastr;
session_start();

use App\Article;
use App\Slider;
use App\Product;
use Auth;
use App\Category;

class CategoryProduct extends Controller
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
    public function add_category_product()
    {
        $this->AuthLogin();
        return view('admin.category.add_category_product');
    }
    public function all_category_product()
    {
        $this->AuthLogin();
        $category_product = CategoryModel::orderBy('category_id', 'DESC')->get();
        $all_category_product = DB::table('t_danhmucsanpham')->orderBy('category_id', 'DESC')->get();
        $manager_category_product = view('admin.category.all_category_product')->with('all_category_product', $all_category_product)
            ->with('category_product', $category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }
    public function save_category_product(Request $request)
    {
        $this->AuthLogin();
        $data = array();
        $data['tendanhmuc'] = $request->tendanhmuc;
        $data['danhmuc_slug'] = $request->danhmuc_slug;
      
        $data['meta_keywords'] = $request->danhmuc_keywords;
        $data['danhmuc_desc'] = $request->danhmuc_desc;
        $data['danhmuc_status'] = $request->danhmuc_status;

        DB::table('t_danhmucsanpham')->insert($data);
      
        Toastr::success('Thêm danh mục sản phẩm thành công', 'Thành công');
        return Redirect::to('all-category-product');
    }
    public function unactive_category_product($category_product_id)
    {
        $this->AuthLogin();
        DB::table('t_danhmucsanpham')->where('category_id', $category_product_id)->update(['danhmuc_status' => 1]);
        // Session::put('message', 'Không kích hoạt danh mục sản phẩm thành công');
        Toastr::error('Không kích hoạt danh mục sản phẩm thành công', 'Không thành công');
        return Redirect::to('all-category-product');
    }
    public function active_category_product($category_product_id)
    {
        $this->AuthLogin();
        DB::table('t_danhmucsanpham')->where('category_id', $category_product_id)->update(['danhmuc_status' => 0]);
        
        Toastr::success('Kích hoạt danh mục sản phẩm thành công', 'Thành công');
        return Redirect::to('all-category-product');
    }
    public function edit_category_product($category_product_id)
    {
        $this->AuthLogin();
        $category = CategoryModel::orderBy('category_id', 'DESC')->get();
        $edit_category_product = DB::table('t_danhmucsanpham')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('admin.category.edit_category_product')->with('edit_category_product', $edit_category_product)
            ->with('category', $category);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this->AuthLogin();
        $data = array();
        $data['tendanhmuc'] = $request->tendanhmuc;
        $data['danhmuc_slug'] = $request->danhmuc_slug;
        $data['meta_keywords'] = $request->danhmuc_keywords;
        $data['danhmuc_desc'] = $request->danhmuc_desc;
        
        DB::table('t_danhmucsanpham')->where('category_id', $category_product_id)->update($data);
        
        Toastr::success('Cập nhật danh mục sản phẩm thành công', 'Thành công');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id)
    {

        DB::table('t_danhmucsanpham')->where('category_id', $category_product_id)->delete();
        Toastr::error('Xóa danh mục sản phẩm thành công', 'Thành công');
        return Redirect::to('all-category-product');
    }

    public function show_category_home(Request $request, $category_slug)
    {
        $category_post = Article::orderBy('article_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();
        //seo 
        $meta_desc = "";
        $meta_keywords = "";
        $meta_title = "";
        $url_canonical = $request->url();

        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

        $category_by_slug = CategoryModel::where('danhmuc_slug', $category_slug)->get();

        $category_by_id = DB::table('tbl_product')->join('t_danhmucsanpham', 'tbl_product.category_id', '=', 't_danhmucsanpham.category_id')
            ->where('t_danhmucsanpham.danhmuc_slug', $category_slug)->paginate(6);

        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');

        foreach ($category_by_slug as $key => $cate) {
            $category_id = $cate->category_id;
        }

        // Xử lý lọc sản phẩm theo giá hoặc sắp xếp
        if (isset($_GET['sort_by'])) {
            $sort_by = $_GET['sort_by'];

            if ($sort_by == 'giam_dan') {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_price', 'DESC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'tang_dan') {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_price', 'ASC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'kytu_za') {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_name', 'DESC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'kytu_az') {
                $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_name', 'ASC')->paginate(6)->appends(request()->query());
            }
        } elseif (isset($_GET['start_price']) && isset($_GET['end_price'])) {
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];
            // Filter products based on price range
            $category_by_id = Product::with('category')
                ->whereBetween('product_price', [$min_price, $max_price])
                ->where('category_id', $category_id)
                ->orderBy('product_price', 'ASC')
                ->get();
        } else {
            // Mặc định hiển thị danh sách sản phẩm theo thứ tự giảm dần của product_id
            $category_by_id = Product::with('category')->where('category_id', $category_id)->orderBy('product_id', 'DESC')->paginate(6)->appends(request()->query());
        }


        foreach ($category_by_id as $key => $val) {
            //seo 
            $meta_desc = "$val->danhmuc_desc";
            $meta_keywords = "$val->meta_keywords";
            $meta_title = "$val->tendanhmuc";
            $url_canonical = $request->url();
        }

        $category_name = DB::table('t_danhmucsanpham')->where('t_danhmucsanpham.danhmuc_slug', $category_slug)->limit(1)->get();

        return view('pages.category.show_category')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('category_by_id', $category_by_id)->with('category_name', $category_name)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)->with('slider', $slider)
            ->with('min_price', $min_price)->with('max_price', $max_price);
    }

    public function export_csv()
    {
        return Excel::download(new ExcelExports, 'danhmucsanpham.xlsx');
    }
    public function import_csv(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new Imports, $path);
        return back();
    }
}
