@extends('layout')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>
            <div class="shopper-informations">
                <div class="row">

                    <div class="col-sm-12 clearfix">
                        @if (\Session::has('error'))
                            <div class="alert alert-danger">{{ \Session::get('error') }}</div>
                            {{ \Session::forget('error') }}
                        @endif
                        @if (\Session::has('success'))
                            <div class="alert alert-success">{{ \Session::get('success') }}</div>
                            {{ \Session::forget('success') }}
                        @endif
                        <div class="form-container">
                            <p style="color: red">Điền thông tin gửi hàng</p>
                            <div class="form-one">
                                <form method="POST">
                                    @csrf
                                    <input type="text" name="s_email" class="s_email"
                                        placeholder="Điền email">
                                    <input type="text" name="s_name" class="s_name"
                                        placeholder="Họ và tên người gửi">
                                    <input type="text" name="s_address" class="s_address"
                                        placeholder="Địa chỉ gửi hàng">
                                    <input type="text" name="s_phone" class="s_phone"
                                        placeholder="Số điện thoại">
                                    <textarea name="s_notes" class="s_notes" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

                                    @if (Session::get('fee'))
                                        <input type="hidden" name="order_fee" class="order_fee"
                                            value="{{ Session::get('fee') }}">
                                    @else
                                        <input type="hidden" name="order_fee" class="order_fee" value="10000">
                                    @endif

                                    @if (Session::get('coupon'))
                                        @foreach (Session::get('coupon') as $key => $cou)
                                            <input type="hidden" name="order_coupon" class="order_coupon"
                                                value="{{ $cou['coupon_code'] }}">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                                    @endif

                                    <div class="">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>

                                            @if (Session::has('success_vnpay'))
                                                <select name="payment_select"
                                                    class="form-control input-sm m-bot15 payment_select">
                                                    <option value="0">Đã thanh toán VNPAY</option>

                                                </select>
                                            @elseif (Session::has('success_momo'))
                                                <select name="payment_select"
                                                    class="form-control input-sm m-bot15 payment_select">
                                                    <option value="2">Đã thanh toán MOMO</option>
                                                </select>
                                            @else
                                                <select name="payment_select"
                                                    class="form-control input-sm m-bot15 payment_select">
                                                    <option value="1">Tiền mặt</option>
                                                </select>
                                            @endif

                                        </div>
                                    </div>

                                    <input type="button" value="Xác nhận đơn hàng" name="send_order"
                                        class="btn btn-primary btn-sm send_order">
                                </form>
                            </div>

                            <div class="form-two">
                                <form>
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Chọn thành phố</label>
                                        <select name="city" id="city"
                                            class="form-control input-sm m-bot15 choose city">
                                            <option value="">Chọn tỉnh thành phố</option>
                                            @foreach ($city as $key => $ci)
                                                <option value="{{ $ci->matinh }}">{{ $ci->tentinh }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Chọn quận huyện</label>
                                        <select name="province" id="province"
                                            class="form-control input-sm m-bot15 province choose">
                                            <option value="">Chọn quận huyện</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Chọn xã phường</label>
                                        <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                            <option value="">Chọn xã phường</option>
                                        </select>
                                    </div>

                                    <input type="button" value="Tính phí vận chuyển" name="calculate_order"
                                        class="btn btn-primary btn-sm calculate_delivery">
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 clearfix">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="table-responsive cart_info">

                            <form action="{{ url('/update-cart') }}" method="POST">
                                @csrf
                                <table class="table table-condensed">
                                    <thead>
                                        <tr class="cart_menu">
                                            <td class="image">Hình ảnh</td>
                                            <td class="description">Tên sản phẩm</td>
                                            <td class="price">Giá sản phẩm</td>
                                            <td class="quantity">Số lượng</td>
                                            <td class="total">Thành tiền</td>
                                            <td class="total">Xử lí</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Session::get('cart') == true)
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach (Session::get('cart') as $key => $cart)
                                                @php
                                                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                    $total += $subtotal;
                                                @endphp

                                                <tr>
                                                    <td class="cart_product">
                                                        <img src="{{ asset('public/uploads/product/' . $cart['product_image']) }}"
                                                            width="90" alt="{{ $cart['product_name'] }}" />
                                                    </td>
                                                    <td class="cart_description">
                                                        <h4><a href=""></a></h4>
                                                        <p>{{ $cart['product_name'] }}</p>
                                                    </td>
                                                    <td class="cart_price">
                                                        <p style="color: red">
                                                            {{ number_format($cart['product_price'], 0, ',', '.') }} VNĐ
                                                        </p>
                                                    </td>
                                                    <td class="cart_quantity">
                                                        <div class="cart_quantity_button">


                                                            <input class="cart_quantity" type="number"
                                                                @if ( Session::get('success_momo') || Session::get('success_vnpay') == true) readonly @endif
                                                                min="1" name="cart_qty[{{ $cart['session_id'] }}]"
                                                                value="{{ $cart['product_qty'] }}">

                                                        </div>
                                                    </td>
                                                    <td class="cart_total">
                                                        <p style="color: red" class="cart_total_price">
                                                            {{ number_format($subtotal, 0, ',', '.') }} VNĐ

                                                        </p>
                                                    </td>
                                                    <td class="cart_delete">

                                                        @if ( Session::get('success_vnpay') || Session::get('success_momo'))
                                                        @else
                                                            <a class="cart_quantity_delete"
                                                                href="{{ url('/del-product/' . $cart['session_id']) }}">Xóa</a>
                                                        @endif


                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                {{-- @if (!Session::get('success_paypal') == true) --}}
                                                @if ( Session::get('success_vnpay') || Session::get('success_momo'))
                                                @else
                                                    <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty"
                                                            class="check_out btn btn-success btn-sm"></td>
                                                    <td><a class="btn btn-danger check_out"
                                                            href="{{ url('/del-all-product') }}">Xóa tất cả</a></td>
                                                    {{-- <td><a class="btn btn-success m-3 check_out" href="{{ route('processTransaction') }}">Thanh toán PayPal</a></td> --}}


                                                    <td>
                                                        @if (Session::get('coupon'))
                                                            <a class="btn btn-success check_out"
                                                                href="{{ url('/unset-coupon') }}">Xóa mã khuyến mãi</a>
                                                        @endif
                                                    </td>
                                                    <style>
                                                        img.check_out.paypal {
                                                            height: 100px;
                                                        }
                                                    </style>
                                                @endif
                                                <td>
                                                </td>
                                                
                                                {{-- LUU O FOOTER --}}
                                                <td style="border: 1px solid #ccc; padding: 10px;">
                                                    <div style="margin-bottom: 10px;">
                                                        <a style="color: green; font-size: 18px;">Tổng tiền:</a>
                                                        <span
                                                            style="color: green; font-size: 18px;">{{ number_format($total, 0, ',', '.') }}
                                                            VNĐ</span>
                                                    </div>

                                                    @if (Session::get('coupon'))
                                                        <div style="margin-bottom: 10px;">
                                                            @foreach (Session::get('coupon') as $key => $cou)
                                                                @if ($cou['coupon_condition'] == 1)
                                                                    <span style="color: red; font-size: 16px;">Mã giảm:
                                                                        {{ $cou['coupon_number'] }}%</span>
                                                                    <p>@php $total_coupon = ($total * $cou['coupon_number']) / 100; @endphp</p>
                                                                    <p>@php $total_after_coupon = $total - $total_coupon; @endphp</p>
                                                                @elseif($cou['coupon_condition'] == 2)
                                                                    <span style="color: red; font-size: 16px;">Mã giảm:
                                                                        {{ number_format($cou['coupon_number'], 0, ',', '.') }}
                                                                        VNĐ</span>
                                                                    <p>@php $total_coupon = $total - $cou['coupon_number']; @endphp</p>
                                                                    @php $total_after_coupon = $total_coupon; @endphp
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    @if (Session::get('fee'))
                                                        <div style="margin-bottom: 10px;">
                                                            <a style="color: red; font-size: 18px;"
                                                                class="cart_quantity_delete"
                                                                href="{{ url('/del-fee') }}">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                            <span style="color: red; font-size: 18px;">Phí vận
                                                                chuyển:</span>
                                                            <span
                                                                style="color: red; font-size: 18px;">{{ number_format(Session::get('fee'), 0, ',', '.') }}VNĐ</span>
                                                        </div>
                                                        <?php $total_after_fee = $total + Session::get('fee'); ?>
                                                    @endif

                                                    <div style="margin-bottom: 10px;">
                                                        <a style="color: red; font-size: 18px;">Tổng còn:</a>
                                                        @php
                                                            if (Session::get('fee') && !Session::get('coupon')) {
                                                                $total_after = $total_after_fee;
                                                            } elseif (!Session::get('fee') && Session::get('coupon')) {
                                                                $total_after = $total_after_coupon;
                                                            } elseif (Session::get('fee') && Session::get('coupon')) {
                                                                $total_after =
                                                                    $total_after_coupon + Session::get('fee');
                                                            } else {
                                                                $total_after = $total;
                                                            }
                                                        @endphp
                                                        <span
                                                            style="color: red; font-size: 18px;">{{ number_format($total_after, 0, ',', '.') }}
                                                            VNĐ</span>
                                                    </div>

                                                    
                                                </td>


                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5">
                                                    <center>
                                                        @php
                                                            echo 'Bạn hãy thêm sản phẩm vào giỏ hàng';
                                                        @endphp
                                                    </center>
                                                </td>

                                            </tr>
                                        @endif
                                    </tbody>



                            </form>
                            @if (Session::get('cart'))
                                @if ( Session::get('success_vnpay') || Session::get('success_momo'))
                                    
                                @else
                                    <tr>
                                        <td>

                                            <form method="POST" action="{{ url('/check-coupon') }}">
                                                @csrf
                                                <input type="text" class="form-control" name="coupon"
                                                    placeholder="Nhập mã giảm giá"><br>
                                                <input type="submit" class="btn btn-success check_coupon"
                                                    name="check_coupon" value="Tính mã giảm giá">

                                            </form>

                                        </td>
                                        <td>
                                            <div class="payment-methods">
                                                <form action="{{ url('/vnpay-payment') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="total_vnpay"
                                                        value="{{ $total_after }}">
                                                  
                                                    <button type="submit" class=" check_out vnpay-button"
                                                        name="redirect">
                                                        <!-- Hiển thị hình ảnh logo của VNPAY -->
                                                        <img src="{{ 'public/fontend/images/vnpay.png' }}" alt="VNPAY"
                                                            class="vnpay-logo">
                                                    </button>
                                                </form>
                                                <style>
                                                    img.vnpay-logo {
                                                        width: 115px;
                                                        height: 42px;
                                                    }
                                                </style>


                                            </div>
                                        </td>
                                        <td>
                                            <div class="payment-methods">
                                                <form action="{{ url('/momo-payment') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="total_momo" value="{{ $total_after }}">
                                                    <button type="submit" class="check_out" name="payUrl"><img
                                                            src="{{ 'public/fontend/images/MoMo.png' }}" alt="VNPAY"
                                                            class="vnpay-logo"></button>
                                                </form>
                                        </td>
                                       
                                    </tr>
                                @endif
                            @endif

                            </table>

                        </div>
                    </div>





                </div>
            </div>




        </div>
    </section>
@endsection
