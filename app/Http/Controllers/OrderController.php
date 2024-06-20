<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Feeship;
use App\Shipping;
use App\Order;
use App\OrderDetails;
use App\Customer;
use Carbon\Carbon;
use App\Coupon;
use PDF;
use App\Product;
use App\Thongke;
use Mail;
use Session;
use Illuminate\Support\Facades\DB;
use App\Slider;
use App\Article;
use Toastr;
class OrderController extends Controller
{
	public function manage_order()
	{
		$orderr = Order::orderby('created_at', 'DESC')->get();
		return view('admin.manage_order')->with(compact('orderr'));
	}
	public function view_order($order_code)
	{
		$order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
		$orderr = Order::where('order_code', $order_code)->get();
		foreach ($orderr as $key => $ord) {
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->s_id;
			$order_status = $ord->order_status;
		}
		$customerr = Customer::where('customer_id', $customer_id)->first();
		$shipping = Shipping::where('s_id', $shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

		foreach ($order_details_product as $key => $order_d) {

			$product_coupon = $order_d->magiamgia;
		}
		if ($product_coupon != 'no') {
			$coupon = Coupon::where('coupon_code', $product_coupon)->first();
			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;
		} else {
			$coupon_condition = 2;
			$coupon_number = 0;
		}

		return view('admin.view_order')->with(compact('order_details', 'customerr', 'shipping', 'coupon_condition', 'coupon_number', 'orderr', 'order_status'));
	}
	public function print_order($checkout_code)
	{
		$pdf = \App::make('dompdf.wrapper');
		$pdf->loadHTML($this->print_order_convert($checkout_code));

		return $pdf->stream();
	}
	public function print_order_convert($checkout_code)
	{
		$order_details = OrderDetails::where('order_code', $checkout_code)->get();
		$order = Order::where('order_code', $checkout_code)->get();
		foreach ($order as $key => $ord) {
			$customer_id = $ord->customer_id;
			$shipping_id = $ord->s_id;
		}
		$customer = Customer::where('customer_id', $customer_id)->first();
		$shipping = Shipping::where('s_id', $shipping_id)->first();

		$order_details_product = OrderDetails::with('product')->where('order_code', $checkout_code)->get();

		foreach ($order_details_product as $key => $order_d) {

			$product_coupon = $order_d->magiamgia;
		}
		if ($product_coupon != 'no') {
			$coupon = Coupon::where('coupon_code', $product_coupon)->first();

			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;

			if ($coupon_condition == 1) {
				$coupon_echo = $coupon_number . '%';
			} elseif ($coupon_condition == 2) {
				$coupon_echo = number_format($coupon_number, 0, ',', '.') . 'đ';
			}
		} else {
			$coupon_condition = 2;
			$coupon_number = 0;

			$coupon_echo = '0';
		}

		$output = '';
		$output .= '<!DOCTYPE html>
		<html lang="vi">
		<head>
			<meta charset="UTF-8">
			<title>Đơn hàng</title>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
			<style>
				body { font-family: DejaVu Sans; font-size: 12px; }
				.table th, .table td { vertical-align: middle; padding: 5px; font-size: 12px; }
				.signature { margin-top: 30px; }
				.signature table { width: 100%; }
				.signature th, .signature td { text-align: center; }
				.text-center { text-align: center; }
				.container { width: 90%; margin: 0 auto; }
				h1, h4 { font-family: DejaVu Sans; }
			</style>
		</head>
		<body>
		<div class="container mt-3">
		<h1><center>Công ty TNHH đồng hồ LINHWATCH</center></h1>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
	
			<p><strong>Người đặt hàng:</strong></p>
			<table class="table table-bordered table-hover">
				<thead class="thead-light">
					<tr>
						<th>Tên</th>
						<th>SĐT</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>' . $customer->customer_name . '</td>
						<td>' . $customer->phone . '</td>
						<td>' . $customer->email . '</td>
					</tr>
				</tbody>
			</table>
	
			<p><strong>Ship hàng tới:</strong></p>
			<table class="table table-bordered table-hover">
				<thead class="thead-light">
					<tr>
						<th>Tên</th>
						<th>Địa chỉ</th>
						<th>SĐT</th>
						<th>Email</th>
						<th>Ghi chú</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>' . $shipping->s_name . '</td>
						<td>' . $shipping->s_address . '</td>
						<td>' . $shipping->s_phone . '</td>
						<td>' . $shipping->s_email . '</td>
						<td>' . $shipping->s_notes . '</td>
					</tr>
				</tbody>
			</table>
	
			<p><strong>Đơn hàng:</strong></p>
			<table class="table table-bordered table-hover">
				<thead class="thead-light">
					<tr>
						<th>Sản phẩm</th>
						<th>Mã giảm giá</th>
						<th>Phí ship</th>
						<th>SL</th>
						<th>Giá</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';
	
		$total = 0;
	
		foreach ($order_details_product as $product) {
			$subtotal = $product->product_price * $product->soluong;
			$total += $subtotal;
	
			$product_coupon = $product->magiamgia != 'no' ? $product->magiamgia : 'không mã';
	
			$output .= '
					<tr>
						<td>' . $product->product_name . '</td>
						<td>' . $product_coupon . '</td>
						<td>' . number_format($product->phiship, 0, ',', '.') . 'đ</td>
						<td>' . $product->soluong . '</td>
						<td>' . number_format($product->product_price, 0, ',', '.') . 'đ</td>
						<td>' . number_format($subtotal, 0, ',', '.') . 'đ</td>
					</tr>';
		}
	
		if ($coupon_condition == 1) {
			$total_after_coupon = ($total * $coupon_number) / 100;
			$total_coupon = $total - $total_after_coupon;
		} else {
			$total_coupon = $total - $coupon_number;
		}
	
		$output .= '
				<tr>
					<td colspan="6" class="text-right">
						<p><strong>Tổng giảm:</strong> ' . $coupon_echo . '</p>
						<p><strong>Phí ship:</strong> ' . number_format($product->phiship, 0, ',', '.') . 'đ</p>
						<p><strong>Thanh toán:</strong> ' . number_format($total_coupon + $product->phiship, 0, ',', '.') . 'đ</p>
					</td>
				</tr>
				</tbody>
			</table>
	
			<div class="signature">
				<table class="table table-borderless">
					<thead>
						<tr>
							<th>Người lập phiếu</th>
							<th>Người nhận</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><br><br>_________________</td>
							<td><br><br>_________________</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		</body>
		</html>';
	
		return $output;
	}
	public function update_qty(Request $request)
	{
		$data = $request->all();
		$order_details = OrderDetails::where('product_id', $data['order_product_id'])->where('order_code', $data['order_code'])->first();
		$order_details->soluong = $data['order_qty'];
		$order_details->save();
	}
	
	public function update_order_qty(Request $request)
	{
		// Cập nhật đơn hàng
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();

		//da gui mail xac nhan
		$now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
		$title_mail = "Đơn hàng đã đặt được xác nhận ngày: " . '' . $now;
		$customer = Customer::where('customer_id', $order->customer_id)->first();;
		$data['email'][] = $customer->email;

		//lay san pham
		foreach ($data['order_product_id'] as $key => $product) {
			$product_mail = Product::find($product);
			foreach ($data['quantity'] as $key2 => $qty) {
				if ($key == $key2) {
					$cart_array[] = array(
						'product_name' => $product_mail['product_name'],
						'product_price' => $product_mail['product_price'],
						'product_qty' => $qty
					);
				}
			}
		}

		//lay shipping
		$details = OrderDetails::where('order_code', $order->order_code)->first();
		$fee_ship = $details->phiship;
		$coupon_mail = $details->magiamgia;

		$shipping = Shipping::where('s_id', $order->s_id)->first();
		$shipping_array = array(
			'fee_ship' => $fee_ship,
			'customer_name' => $customer->customer_name,
			's_name' => $shipping['s_name'],
			's_email' => $shipping['s_email'],
			's_phone' => $shipping['s_phone'],
			's_address' => $shipping['s_address'],
			's_notes' => $shipping['s_notes'],
			's_method' => $shipping['s_method'],

		);
		//lay ma giam gia va ma code cua ma giam gia
		$ordercode_mail = array(
			'coupon_code' => $coupon_mail,
			'order_code' => $details->order_code
		);

		Mail::send(
			'admin.xacnhandon',
			['cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail],
			function ($message) use ($title_mail, $data) {
				$message->to($data['email'])->subject($title_mail);
				$message->from($data['email'], $title_mail);
			}
		);

		// Lấy ngày đơn hàng
		$order_date = $order->order_date;

		// Tìm thống kê cho ngày hiện tại
		$statistic = Thongke::where('order_date', $order_date)->first();

		// Nếu không có thống kê, tạo mới
		if (!$statistic) {
			$statistic = new Thongke();
			$statistic->order_date = $order_date;
			$statistic->gia = 0;
			$statistic->soluong = 0;
			$statistic->loinhuan = 0;
			$statistic->total_order = 0;
		}

		if ($order->order_status == 2) {
			// Khởi tạo các biến
			$total_order = 0;
			$gia = 0;
			$loinhuan = 0;
			$soluong = 0;

			// Lặp qua các sản phẩm trong đơn hàng
			foreach ($data['order_product_id'] as $key => $product_id) {
				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;
				$product_price = $product->product_price;
				$product_cost = $product->product_cost;
				$qty = $data['quantity'][$key];

				// Cập nhật thông tin sản phẩm
				$product->product_quantity -= $qty;
				$product->product_sold += $qty;
				$product->save();

				// Cập nhật thông tin doanh thu và số lượng
				$soluong += $qty;
				$total_order++;
				$gia += $product_price * $qty;
				$loinhuan = $gia - ($product_cost * $qty); // Giả sử 1000 là chi phí cố định
			}

			// Cập nhật thông tin thống kê
			$statistic->gia += $gia;
			$statistic->soluong += $soluong;
			$statistic->loinhuan += $loinhuan;
			$statistic->total_order += $total_order;
			$statistic->save();
		}
	}


	public function delete_order($orderCode)
	{

		$order = Order::where('order_code', $orderCode)->first();
		if ($order) {
			$order->delete();
			return redirect('manage-order')->with('success', 'Đơn hàng đã được xóa thành công.');
		} else {
			return redirect('manage-order')->with('error', 'Không tìm thấy đơn hàng.');
		}
	}
	public function lichsudh(Request $request)
	{
		if (!Session::get('customer_id')) {
			return redirect('login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng');
		} else {

			//post
			$category_post = Article::orderBy('article_id', 'DESC')->get();

			//slider
			$slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();

			//seo 
			$meta_desc = "Lịch sử đơn hàng";
			$meta_keywords = "Lịch sử đơn hàng";
			$meta_title = " Lịch sử đơn hàng";
			$url_canonical = $request->url();

			$cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
			$brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status','0')->orderby('brand_id','desc')->get(); 

			$orderr = Order::where('customer_id', Session::get('customer_id'))->orderby('order_id', 'DESC')->get();

			return view('pages.lichsudonhang.donhang')->with('category', $cate_product)->with('brand', $brand_product)
				->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
				->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post)->with('orderr', $orderr);
		}
	}
	public function lich_su_don_hang(Request $request, $order_code)
	{
		if (!Session::get('customer_id')) {
			return redirect('login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử đơn hàng');
		} else {

			//post
			$category_post = Article::orderBy('article_id', 'DESC')->get();
			//slider
			$slider = Slider::orderBy('slider_id', 'desc')->where('slider_status', '1')->take(3)->get();

			//seo 
			$meta_desc = "Lịch sử đơn hàng";
			$meta_keywords = "Lịch sử đơn hàng";
			$meta_title = " Lịch sử đơn hàng";
			$url_canonical = $request->url();

			$cate_product = DB::table('t_danhmucsanpham')->where('danhmuc_status', '0')->orderby('category_id', 'desc')->get();
			$brand_product = DB::table('t_thuonghieu')->where('thuonghieu_status', '0')->orderby('brand_id', 'desc')->get();

			//xem lich su don hang
			$order_details = OrderDetails::with('product')->where('order_code', $order_code)->get();
			$orderr = Order::where('order_code', $order_code)->first();

			$customer_id = $orderr->customer_id;
			$shipping_id = $orderr->s_id;
			$order_status = $orderr->order_status;

			$customerr = Customer::where('customer_id', $customer_id)->first();
			$shipping = Shipping::where('s_id', $shipping_id)->first();

			$order_details_product = OrderDetails::with('product')->where('order_code', $order_code)->get();

			foreach ($order_details_product as $key => $order_d) {

				$product_coupon = $order_d->magiamgia;
			}
			if ($product_coupon != 'no') {
				$coupon = Coupon::where('coupon_code', $product_coupon)->first();
				$coupon_condition = $coupon->coupon_condition;
				$coupon_number = $coupon->coupon_number;
			} else {
				$coupon_condition = 2;
				$coupon_number = 0;
			}
			
			return view('pages.lichsudonhang.lichsudonhang')->with('category', $cate_product)->with('brand', $brand_product)
				->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
				->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post)->with('order_details', $order_details)
				->with('customerr', $customerr)->with('shipping', $shipping)->with('coupon_condition', $coupon_condition)
				->with('coupon_number', $coupon_number)->with('orderr', $orderr)->with('order_status', $order_status);
		}
	}
	public function huy_don_hang(Request $request){
		$data = $request->all();
		$orderr = Order::where('order_code',$data['order_code'])->first();
		$orderr->order_destroy = $data['lydohuy'];
		$orderr->order_status = 3;
		$orderr->save();

	}
}
