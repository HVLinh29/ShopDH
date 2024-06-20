@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin đăng nhập
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th style="color:brown">Tên khách hàng</th>
                            <th style="color:brown">Số điện thoại</th>
                            <th style="color:brown">Email</th>

                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $customerr->customer_name }}</td>
                            <td>{{ $customerr->phone }}</td>
                            <td>{{ $customerr->email }}</td>
                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <br>
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển hàng
            </div>


            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th style="color:brown">Tên người vận chuyển</th>
                            <th style="color:brown">Địa chỉ</th>
                            <th style="color:brown">Số điện thoại</th>
                            <th style="color:brown">Email</th>
                            <th style="color:brown">Ghi chú</th>
                            <th style="color:brown">Hình thức thanh toán</th>


                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>

                            <td>{{ $shipping->s_name }}</td>
                            <td>{{ $shipping->s_address }}</td>
                            <td>{{ $shipping->s_phone }}</td>
                            <td>{{ $shipping->s_email }}</td>
                            <td>{{ $shipping->s_notes }}</td>
                            <td>
                                @if ($shipping->s_method == 0)
                                    Thanh toán VNPAY
                                @elseif($shipping->s_method == 1)
                                    Tiền mặt
                                @else
                                Thanh toán MOMO
                                @endif
                            </td>


                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <br><br>

    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>

                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                           
                            <th style="color:brown">Tên sản phẩm</th>
                            <th style="color:brown">Số lượng kho còn</th>
                            <th style="color:brown">Mã giảm giá</th>
                            <th style="color:brown">Phí ship hàng</th>
                            <th style="color:brown">Số lượng</th>
                            <th style="color:brown">Giá bán</th>
                            <th style="color:brown">Giá gốc</th>
                            <th style="color:brown">Tổng tiền</th>

                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($order_details as $key => $details)
                            @php
                                $i++;
                                $subtotal = $details->product_price * $details->soluong;
                                $total += $subtotal;
                            @endphp
                            <tr class="color_qty_{{ $details->product_id }}">

                              
                                <td>{{ $details->product_name }}</td>
                                <td>{{ $details->product->product_quantity }}</td>
                                <td>
                                    @if ($details->magiamgia != 'no')
                                        {{ $details->magiamgia }}
                                    @else
                                        Không mã
                                    @endif
                                </td>
                                <td>{{ number_format($details->phiship, 0, ',', '.') }}đ</td>
                                <td>

                                    <input type="number" min="1" {{ $order_status == 2 ? 'disabled' : '' }}
                                        class="order_qty_{{ $details->product_id }}"
                                        value="{{ $details->soluong }}" name="product_sales_quantity">

                                    <input type="hidden" name="order_qty_storage"
                                        class="order_qty_storage_{{ $details->product_id }}"
                                        value="{{ $details->product->product_quantity }}">

                                    <input type="hidden" name="order_code" class="order_code"
                                        value="{{ $details->order_code }}">

                                    <input type="hidden" name="order_product_id" class="order_product_id"
                                        value="{{ $details->product_id }}">

                                    @if ($order_status != 2)
                                        <button class="btn btn-default update_quantity_order"
                                            data-product_id="{{ $details->product_id }}" name="update_quantity_order">Cập
                                            nhật</button>
                                    @endif

                                </td>
                                <td>{{ number_format($details->product_price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($details->product->product_cost, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2">
                                @php
                                    $total_coupon = 0;
                                @endphp
                                @if ($coupon_condition == 1)
                                    @php
                                        $total_after_coupon = ($total * $coupon_number) / 100;
                                        echo 'Tổng giảm :' . number_format($total_after_coupon, 0, ',', '.') . '</br>';
                                        $total_coupon = $total + $details->phiship - $total_after_coupon;
                                    @endphp
                                @else
                                    @php
                                        echo 'Tổng giảm :' . number_format($coupon_number, 0, ',', '.') . ' VNĐ' . '</br>';
                                        $total_coupon = $total + $details->phiship - $coupon_number;

                                    @endphp
                                @endif

                                Phí ship : {{ number_format($details->phiship, 0, ',', '.') }} VNĐ</br>
                                Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }} VNĐ
                              
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                @foreach ($orderr as $key => $or)
                                    @if ($or->order_status == 1)
                                        <form>
                                            @csrf
                                            <select class="form-control order_details">

                                                <option id="{{ $or->order_id }}" selected value="1">Chưa xử lý
                                                </option>
                                                <option id="{{ $or->order_id }}" value="2">Đã xử lý
                                                </option>

                                            </select>
                                        </form>
                                    @else
                                        <form>
                                            @csrf
                                            <select class="form-control order_details">

                                                <option disabled id="{{ $or->order_id }}" value="1">Chưa xử lý
                                                </option>
                                                <option id="{{ $or->order_id }}" selected value="2">Đã xử lý</option>

                                            </select>
                                        </form>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a target="_blank" href="{{ url('/print-order/' . $details->order_code) }}">In đơn hàng</a>
            </div>

        </div>
    </div>
@endsection
