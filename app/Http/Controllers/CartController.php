<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

use Cart;
use App\Coupon;
use PDO;
use Carbon\Carbon;
use App\Article;
use App\Slider;

class CartController extends Controller
{

    public function show_cart_qty()
    {

        $cart = count(Session::get('cart'));
        $output ='';
        $output.=' <span class="badges">'.$cart.'</span>';
        echo $output;
    }
    public function check_coupon(Request $request)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');
        $data = $request->all();
        if (Session::get('customer_id')) {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)
                ->where('coupon_used', 'LIKE', '%' . Session::get('customer_id') . '%')->first();
            if ($coupon) {
                return redirect()->back()->with('error', 'Mã giảm giá đã sử dung, quý khách vui lòng nhập mã khác');
            } else {
                $coupon_login = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->first();// kiem tra ma giam gia con oat dong ko
                if ($coupon_login) {
                    $count_coupon = $coupon_login->count();// kiem tra xem co ton tai cai ma giam gia ko
                    if ($count_coupon > 0) { // nue ton tai thi kiem tra xem co ton tai session ko
                        $coupon_session = Session::get('coupon');
                        if ($coupon_session == true) {
                            $is_avaiable = 0;
                            if ($is_avaiable == 0) {
                                $cou[] = array( // neu ton tai thi se luu thong tin cua ma do vao 1 mang va luu vao trong phien
                                    'coupon_code' => $coupon_login->coupon_code,
                                    'coupon_condition' => $coupon_login->coupon_condition,
                                    'coupon_number' => $coupon_login->coupon_number,
                                );
                                Session::put('coupon', $cou);
                            }
                        } else {
                            $cou[] = array( // neu ko ton tai thi luu truc tiep vao mang do va luu vao phien
                                'coupon_code' => $coupon_login->coupon_code,
                                'coupon_condition' => $coupon_login->coupon_condition,
                                'coupon_number' => $coupon_login->coupon_number,
                            );
                            Session::put('coupon', $cou);
                        }
                        Session::save();
                        return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
                    }
                } else {
                    return redirect()->back()->with('error', 'Mã giảm giá không tồn tại, hoặc đã hết hạn');
                }
            }
        }
        //day la su  dung cho viec chua dang nhap
        else {
            $coupon = Coupon::where('coupon_code', $data['coupon'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->first();
            if ($coupon) {
                $count_coupon = $coupon->count();
                if ($count_coupon > 0) {
                    $coupon_session = Session::get('coupon');
                    if ($coupon_session == true) {
                        $is_avaiable = 0;
                        if ($is_avaiable == 0) {
                            $cou[] = array(
                                'coupon_code' => $coupon->coupon_code,
                                'coupon_condition' => $coupon->coupon_condition,
                                'coupon_number' => $coupon->coupon_number,
                            );
                            Session::put('coupon', $cou);
                        }
                    } else {
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,
                        );
                        Session::put('coupon', $cou);
                    }
                    Session::save();
                    return redirect()->back()->with('message', 'Thêm mã giảm giá thành công');
                }
            } else {
                return redirect()->back()->with('error', 'Mã giảm giá không tồn tại, hoặc đã hết hạn');
            }
        }
    }
   
    public function add_cart_ajax(Request $request)
    {

        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart == true) {
            $is_avaiable = 0;
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $is_avaiable++;
                }
            }
            if ($is_avaiable == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_quantity' => $data['cart_product_quantity'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_quantity' => $data['cart_product_quantity'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            Session::put('cart', $cart);
        }

        Session::save();
    }
    public function gio_hang(Request $request)
    {

        $slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();
        $category_post = Article::orderBy('article_id', 'DESC')->get();
        $meta_desc = "Giỏ hàng của bạn";
        $meta_keywords = "Giỏ hàng Ajax";
        $meta_title = "Giỏ hàng Ajax";
        $url_canonical = $request->url();
        //--seo
        $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.cart.cart_ajax')->with('category', $cate_product)->with('brand', $brand_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('category_post', $category_post)->with('slider', $slider);
    }
    public function delete_product($session_id)
    {
        $cart = Session::get('cart');//lay gio hang hien tai

        if ($cart == true) { //neu ton tai gio hang/ lap qua tat ca cac san pham trong gio hang
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {// neu ton ai cai session id do thi se xoa
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);// cap nhat lai gio hang 
            return redirect()->back()->with('message', 'Xóa sản phẩm thành công');
        } else {
            return redirect()->back()->with('message', 'Xóa sản phẩm thất bại');
        }
    }
    public function update_cart(Request $request)
    {
        $data = $request->all();// lay tat ca du lieu
        $cart = Session::get('cart');
        if ($cart == true) {
            $message = '';

            foreach ($data['cart_qty'] as $key => $qty) { // lay va lap lai so luong da duoc cung cap
                $i = 0;
                foreach ($cart as $session => $val) {
                    $i++;

                    if ($val['session_id'] == $key && $qty < $cart[$session]['product_quantity']) {// neu ma so luong moi nho hon so luong san pham hien tai

                        $cart[$session]['product_qty'] = $qty; // cho phep cap nhat so luong     san pham
                        $message .= '<p style="color:brow">' . $i . ') Cập nhật số lượng :' . $cart[$session]['product_name'] . ' thành công</p>';
                    } elseif ($val['session_id'] == $key && $qty > $cart[$session]['product_quantity']) {
                        $message .= '<p style="color:red">' . $i . ') Cập nhật số lượng :' . $cart[$session]['product_name'] . ' thất bại</p>';
                    }
                }
            }

            Session::put('cart', $cart);
            return redirect()->back()->with('message', $message);
        } else {
            return redirect()->back()->with('message', 'Cập nhật số lượng thất bại');
        }
    }
    public function delete_all_product()
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Xóa hết giỏ hàng thành công');
        }
    }
}
