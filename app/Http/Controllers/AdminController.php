<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

use Socialite;
use App\LoginGG;
use App\Login;
use App\Product;
use App\Baiviet;
use App\Order;
use App\Video;
use App\Customer;
use App\Thongke;
use App\Rules\Captcha;
use Validator;
use Auth;
use Carbon\Carbon;

class AdminController extends Controller
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


    public function index()
    {
        return view('admin.admin_auth.login_auth');
    }


    public function dashboard(Request $request)
    {
    
        $data = $request->validate([
            //validation laravel 
            'admin_email' => 'required',
            'admin_password' => 'required'
            
        ]);


        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if ($login) {
            $login_count = $login->count();
            if ($login_count > 0) {
                Session::put('admin_name', $login->admin_name);// luu ten vao session
                Session::put('admin_id', $login->admin_id);// luu id vao session
                return Redirect::to('/dashboard');
            }
        } else {
            Session::put('message', 'Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return Redirect::to('/admin');
        }
    }
    public function logout()
    {
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }

    public function show(Request $request)
    {
        $this->AuthLogin();// kiem tra xem ngui dung co da dang nhap hay chua

        $daudautuan_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfWeek()->toDateString();// Sét thời gian về ngày đầu tiên của tháng hiện tại và chuyển sang chuổi định dạng YYYY-MM-DD.
        $dauthang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonths()->startOfMonth()->toDateString();// trù di 1 thang tu thoi gian hien tai. dat thoi giam bfe ngay cuoi cung cua thang hien tai
        $cuoithang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonths()->endOfMonth()->toDateString();// trù di 1 thang tu thoi gian hien tai. dat thoi giam bfe ngay cuoi cung cua thang truoc
        $dauthang_nay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();// dat thoi gian ve ngay dau tien cua thang hien tao
        $motnam = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();// thoi gian hien tai tru di 365 ngay se ra thoi gian 1 nam
        $hientai = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        
        $product = Product::all()->count();
        $product_view = Product::orderBy('product_view', 'DESC')->take(10)->get();
        $baiviet = Baiviet::all()->count();
        $baiviet_view = Baiviet::orderBy('baiviet_view', 'DESC')->take(20)->get();
        $order = Order::all()->count();
        $customer = Customer::all()->count();
        
        // Tính doanh thu
        $doanhthu_homnay = Thongke::whereDate('order_date', $hientai)->sum('gia');// PT WD lọc các bản ghi dua tren gia tri cua 1 cot kieu ngay thang
        $doanhthu_tuan = Thongke::whereBetween('order_date', [$daudautuan_nay, $hientai])->sum('gia');// loc cac ban ghi dua tren gia tri cua 1 cot nam trong khoang TG nhat dinh
        $doanhthu_thang = Thongke::whereBetween('order_date', [$dauthang_nay, $hientai])->sum('gia');
        $doanhthu_nam = Thongke::whereBetween('order_date', [$motnam, $hientai])->sum('gia');
        $thangtruoc = Thongke::whereBetween('order_date', [$dauthang_truoc, $cuoithang_truoc])->sum('gia');
        

        return view('admin.dashboard')->with(compact(
            'order',
            'customer',
            'baiviet_view',
            'product_view',
            'product',
            'baiviet',
            'doanhthu_homnay',
            'doanhthu_thang',
            'doanhthu_nam',
            'thangtruoc',
            'doanhthu_tuan'
        ));
    }

    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Thongke::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->gia,
                'profit' => $val->loinhuan,
                'quantity' => $val->soluong,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request)
    {
        $data = $request->all();

        // Lấy ngày đầu tháng hiện tại
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        // Lấy ngày đầu tháng trước
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        // Lấy ngày cuối tháng trước
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        // Lấy ngày trước 7 ngày
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        // Lấy ngày trước 365 ngày
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        // Lấy ngày hiện tại
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == '7ngay') {
            $get = Thongke::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        } elseif ($data['dashboard_value'] == 'thangtruoc') {
            $get = Thongke::whereBetween('order_date', [$dauthangtruoc, $cuoithangtruoc])->orderBy('order_date', 'ASC')->get();
        } elseif ($data['dashboard_value'] == 'thangnay') { // Sửa ở đây
            $get = Thongke::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
        } else {
            $get = Thongke::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }

        $chart_data = [];
        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->gia,
                'profit' => $val->loinhuan,
                'quantity' => $val->soluong,
            );
        }
        echo json_encode($chart_data);
    }
    public function days_order()
    {
        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(60)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Thongke::whereBetween('order_date', [$sub60days, $now])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->gia,
                'profit' => $val->loinhuan,
                'quantity' => $val->soluong,
            );
        }
        echo json_encode($chart_data);
    }
    public function customer_gg()
    {
        config(['services.google.redirect' => env('GOOGLE_URL')]);
        return Socialite::driver('google')->redirect();
    }
    public function callback_google_customer()
    {
        config(['services.google.redirect' => env('GOOGLE_URL')]);
        $users = Socialite::driver('google')->stateless()->user();
        $authUser = $this->findOrCreateUser($users, 'google');
        if ($authUser) {
            $account_name = Customer::where('customer_id', $authUser->user)->first();
            Session::put('customer_id', $account_name->customer_id);

            Session::put('customer_name', $account_name->customer_name);
        } elseif ($customer_new) {
            $account_name = Customer::where('customer_id', $authUser->user)->first();
            Session::put('customer_id', $account_name->customer_id);

            Session::put('customer_name', $account_name->customer_name);
        }
        return redirect('/thanhtoan')->with('message', 'Đăng nhập thành công');
    }
    public function findOrCreateUser($users, $provider)
    {
        $authUser = LoginGG::where('gg_user_id', $users->id)->where('gg_user_email', $users->email)->first();
        if ($authUser) {
            return $authUser;
        } else {
            $customer_new = new LoginGG([
                'gg_user_id' => $users->id,
                'gg_user_email' => $users->email,
                'gg' => strtoupper($provider)
            ]);
            $customer = Customer::where('customer_email', $users->email)->first();

            if (!$customer) {
                $customer = Customer::create([
                    'customer_name' => $users->name,
                    'customer_email' => $users->email,
                    'customer_password' => '',
                    'customer_phone' => ''


                ]);
            }
            $customer_new->customer()->associate($customer);

            $customer_new->save();
            return $customer_new;
        }
    }
}
