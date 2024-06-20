<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

use App\Slider;
use App\Article;
use App\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //post
        $category_post = Article::orderBy('article_id', 'DESC')->get();

        //slider
        $slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();

        //seo 
        $meta_desc = "LINHWATCH";
        $meta_keywords = "LINHWATCH";
        $meta_title = " LINHWATCH";
        $url_canonical = $request->url();

        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

        $all_product = DB::table('tbl_product')->where('product_status', '0')->where('product_view','>','2')->orderby('product_id', 'desc')->limit(4)->get();
        $all_product_sl = DB::table('tbl_product')->where('product_status', '0')->where('product_sold','>=','5')->orderby('product_sold', 'desc')->limit(4)->get();
        $all_product_km = DB::table('tbl_product')->where('product_status', '0')->where('product_km','>=','1000000')->orderby('product_id', 'desc')->limit(4)->get();

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('all_product_km', $all_product_km)
            ->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post)->with('all_product_sl', $all_product_sl);
    }
    public function search(Request $request)
    {

        $category_post = Article::orderBy('article_id', 'DESC')->get();
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();

        $keywords = $request->keywords_submit;
        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();

        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('search_product', $search_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)->with('slider', $slider);
    }
    public function autocomplete_ajax(Request $request)
    {
        $data = $request->all();

        if ($data['query']) {// kiem tra xem co query hay ko. co nghia la nguoi dung co nhap tu khoa khong
            $product = Product::where('product_status', '0')->where('product_name', 'LIKE', '%' . $data['query'] . '%')->get();//lay cac san pham co chuoi ki tu do roi hien thi ra
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach ($product as $key => $val) {
                $output .= '<li><a href="#">' . $val->product_name . '</a></li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }
    
    public function load_more(Request $request)
    {
        $data = $request->all();
        if ($data['id'] > 0) {
            $all_product = Product::where('product_status', '0')
                ->where('product_id', '<', $data['id'])
                ->orderBy('product_id', 'DESC')
                ->take(9)
                ->get();
        } else {
            $all_product = Product::where('product_status', '0')
                ->orderBy('product_id', 'DESC')
                ->take(6)
                ->get();
        }
    
        $output = '';
        if (!$all_product->isEmpty()) {
            foreach ($all_product as $key => $pro) {
                $last_id = $pro->product_id;
                $output .= '<div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <input type="hidden" value="' . $pro->product_id . '" class="cart_product_id_' . $pro->product_id . '">
                                            <input type="hidden" id="wishlist_productname' . $pro->product_id . '" value="' . $pro->product_name . '" class="cart_product_name_' . $pro->product_id . '">
                                            <input type="hidden" value="' . $pro->product_quantity . '" class="cart_product_quantity_' . $pro->product_id . '">
                                            <input type="hidden" value="' . $pro->product_image . '" class="cart_product_image_' . $pro->product_id . '">
                                            <input type="hidden" id="wishlist_productprice' . $pro->product_id . '" value="' . number_format($pro->product_price, 0, ',', '.') . 'VNĐ">
                                            <input type="hidden" value="' . $pro->product_price . '" class="cart_product_price_' . $pro->product_id . '">
                                            <input type="hidden" value="1" class="cart_product_qty_' . $pro->product_id . '">
                                            <a id="wishlist_producturl' . $pro->product_id . '" href="' . url('chi-tiet-san-pham/' . $pro->product_slug) . '">
                                                <div class="position-relative">
                                                    <img id="wishlist_productimage' . $pro->product_id . '" src="' . url('public/uploads/product/' . $pro->product_image) . '" alt="' . $pro->product_name . '" />';
                if ($pro->product_km != 0) {
                    $output .= '<a style="color:white" class="discount-badge">
                                    -' . round((($pro->product_km - $pro->product_price) / $pro->product_km) * 100) . '%
                                </a>';
                }
                $output .= '</div>
                                <p style="margin-top: 30px">' . $pro->product_name . '</p>';
                if ($pro->product_km != 0) {
                    $output .= '<div> 
                                    <h5 style="display: inline; text-decoration: line-through;">
                                        ' . number_format($pro->product_km, 0, ',', '.') . ' VNĐ
                                    </h5>
                                    <h4 style="display: inline;color:red">
                                        ' . number_format($pro->product_price, 0, ',', '.') . ' VNĐ
                                    </h4>
                                </div>';
                } else {
                    $output .= '<div>
                    <h4 style="display: inline;color:red">
                                    ' . number_format($pro->product_price, 0, ',', '.') . ' VNĐ
                                </h4>   </div>';
                }
                $output .= '</br></a>
                            <div class="row"><style>
                            .choose {
                                margin-top: 10px;
                                margin-bottom: 10px;
                            }</style>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-a btn-danger" id="' . $pro->product_id . '" onclick="Addtocart(this.id);">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <input type="button" data-toggle="modal" onclick="Xemnhanh(this.id);" data-target="#xemnhanh" class="btn btn-success" id="' . $pro->product_id . '" name="add-to-cart" value="Xem nhanh">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li>
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                                <button class="button_wishlist" id="' . $pro->product_id . '" onclick="add_wishlist(this.id);">
                                    <span>Yêu thích</span>
                                </button>
                            </li>
                           
                        </ul>
                    </div>

                </div>
            </div>';
            }
            $output .= '<div class="text-center mt-4">
                            <button type="button" name="load_more_button" class="btn btn-success btn-lg load-more-btn" id="load_more_button" data-id="' . $last_id . '">
                                Xem thêm <i class="fas fa-arrow-down"></i>
                            </button>
                        </div>';
        } else {
            $output .= '<div class="text-center mt-4">
                            <button type="button" name="load_more_button" class="btn btn-danger btn-lg" disabled>
                                Đang cập nhật
                            </button>
                        </div>';
        }
    
        echo $output;
    }
    

    
}

