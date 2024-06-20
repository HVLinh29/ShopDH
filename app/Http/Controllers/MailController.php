<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Coupon;
use App\Customer;
use Carbon\Carbon;
use Mail;

use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;
session_start();
use App\Slider;
use App\CatePost;
use App\Product;

class MailController extends Controller
{
    public function send_mail()
    {

        $to_name = "VLinh C8";
        $to_email = "20111061462@hunre.edu.vn"; // tat ca mail duoc dyi tu mail nay


        $data = array("name" => "Mail từ tài khoản Khách hàng", "body" => 'Mail gửi về vấn về hàng hóa');

        Mail::send('pages.send_mail', $data, function ($message) use ($to_name, $to_email) {

            $message->to($to_email)->subject('Mã giảm giá khi mua đồng hồ');
            $message->from($to_email, $to_name);
        });
    }
    public function send_coupon_vip($coupon_time,$coupon_condition,$coupon_number,$coupon_code){
        $customer_vip = Customer::where('customer_vip',1)->get();
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start = $coupon->coupon_date_start;
        $end = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyễn mãi ngày".''.$now;

        $data = [];
        foreach($customer_vip as $vip){
            $data['email'][]= $vip->customer_email;// them cac email cua khach hang vip vao day

        }// them cac thong tin cuua ma khuyen mai vao day
        $coupon = array(
            'start' =>$start,
            'end' =>$end,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.send_mail', ['coupon'=> $coupon], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });
        
        return redirect()->back()->with('message','Gửi mã vip thành công');

    }
    public function send_coupon($coupon_time,$coupon_condition,$coupon_number,$coupon_code){
        $customer = Customer::where('customer_vip','=',NULL)->get();
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start = $coupon->coupon_date_start;
        $end = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Mã khuyễn mãi ngày".''.$now;

        $data = [];
        foreach($customer as $thuong){
            $data['email'][]= $thuong->customer_email;

        }
        $coupon = array(
            'start' =>$start,
            'end' =>$end,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.send_coupon', ['coupon' => $coupon], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'], $title_mail);
        });
        return redirect()->back()->with('message','Gửi mã thường thành công');
    }
    public function quen_mk(Request $request){
         //post
         $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

         //slider
         $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(3)->get();
        
         //seo 
         $meta_desc = "Quên mật khẩu";
         $meta_keywords = "Quên mật khẩu";
         $meta_title = " Quên mật khẩu";
         $url_canonical = $request->url();
 
         $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
         $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 
 
         $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->limit(9)->get();
 
         return view('pages.thanhtoan.quenpass')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
         ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
         ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post);
    }
    
    public function recover_pass(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail ="Lấy lại mật khẩu".' '.$now;
        $customer = Customer::where('customer_email','=',$data['email_account'])->get();
        foreach($customer as $key =>$value){
            $customer_id = $value->customer_id;
        }
    
        if($customer){
            $count_customer =  $customer->count();
            if($count_customer==0){
                session()->flash('message','Tài khoản không tồn tại');
                return redirect()->back();
            }
            else{
                $token_random = Str::random();
                $customer = Customer::find($customer_id);
                $customer->customer_rpass = $token_random;
                $customer->save();
    
                $to_email = $data['email_account'];
                $link_reset_pass = url('new-pass?email='.$to_email.'&token='.$token_random);
    
                $data = array("name" => $title_mail, "body" => $link_reset_pass, 'email' => $data['email_account']);
    
                Mail::send('pages.thanhtoan.quenpass_notify', ['data'=>$data], function ($message) use ($title_mail, $data) {
                    $message->to($data['email'])->subject($title_mail);
                    $message->from($data['email'], $title_mail);
                });
    
                session()->flash('message','Gửi mail thành công');
                return redirect()->back();
            }
        }
    }
    
    public function new_pass(Request $request){
         //post
         $category_post = CatePost::orderBy('cate_post_id','DESC')->get();

         //slider
         $slider = Slider::orderBy('slider_id','desc')->where('slider_status','1')->take(3)->get();
        
         //seo 
         $meta_desc = "Quên mật khẩu";
         $meta_keywords = "Quên mật khẩu";
         $meta_title = " Quên mật khẩu";
         $url_canonical = $request->url();
 
         $cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
         $brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 
 
         $all_product = DB::table('tbl_product')->where('product_status','0')->orderby('product_id','desc')->limit(9)->get();
 
         return view('pages.thanhtoan.matkhaumoi')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product)
         ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)
         ->with('url_canonical',$url_canonical)->with('slider',$slider)->with('category_post',$category_post);
        
    }

    public function new_pass_new(Request $request){
        $data = $request->all();
        $token_random = Str::random();
        $customer = Customer::where('customer_email','=',$data['email'])->where('customer_rpass','=',$data['token'])->get();
        $count = $customer->count();
        if($count>0){
           foreach($customer as $key =>$cus){
            $customer_id = $cus->customer_id;
           }
           $reset = Customer::find($customer_id);
           $reset->customer_password =  md5($data['pass_account']);
           $reset->customer_rpass = $token_random;
           $reset->save();
           session()->flash('message', 'Đổi mật khẩu thành công');
       return redirect('login-checkout');
        }else{
            session()->flash('error', 'Đổi mật khẩu thất bại');
        return redirect('quen-mk');
        }
       
   }
    
}
