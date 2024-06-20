<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xác nhận đơn hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #0080ff;
            margin-bottom: 30px;
        }

        h3 {
            color: #0080ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Xác nhận giao hàng</h2>
        <p>Xin chào, chúng tôi xác nhạn bạn đã đặt hàng ở shop chúng tôi</p>
        <p>Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi. Dưới đây là các thông tin về đơn hàng của bạn:</p>

        <h3>Thông tin giao hàng:</h3>
        <ul>
            <li><strong>Khách hàng:</strong> {{ $shipping_array['customer_name'] }}</li>
            <li><strong>Tên người nhận:</strong> {{ $shipping_array['s_name'] }}</li>
            <li><strong>Email:</strong> {{ $shipping_array['s_email'] }}</li>
            <li><strong>Số điện thoại:</strong> {{ $shipping_array['s_phone'] }}</li>
            <li><strong>Địa chỉ giao hàng:</strong> {{ $shipping_array['s_address'] }}</li>
            <li><strong>Ghi chú:</strong> {{ $shipping_array['s_notes'] }}</li>
            <li>
                <strong>Phương thức giao hàng:</strong>
                @if ($shipping_array['s_method'] == '0')
                Thanh toán VNPAY
                @elseif($shipping_array['s_method'] == '1')
                    Tiền mặt
                @else
                Thanh toán MOMO
                @endif
            </li>
            <li><strong>Phí ship:</strong> {{ number_format($shipping_array['fee_ship'], 0, ',', '.') }} VNĐ</li>
        </ul>

        <h3>Thông tin mã giảm giá:</h3>
        <p><strong>Mã giảm giá:</strong> {{ $code['coupon_code'] }}</p>
        <p><strong>Mã đơn hàng:</strong> {{ $code['order_code'] }}</p>

        <h3>Thông tin sản phẩm chúng tôi đã xác nhận:</h3>
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPayment = 0; // Khởi tạo biến tổng tiền thanh toán
                @endphp
                @foreach ($cart_array as $cart)
                    @php
                        // Tính thành tiền cho từng sản phẩm
                        $subtotal = $cart['product_price'] * $cart['product_qty'];
                        // Thêm thành tiền vào tổng tiền thanh toán
                        $totalPayment += $subtotal;
                    @endphp
                    <tr>
                        <td>{{ $cart['product_name'] }}</td>
                        <td>{{ number_format($cart['product_price'], 0, ',', '.') }} VNĐ</td>
                        <td>{{ $cart['product_qty'] }}</td>
                        <td>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <strong>Tổng tiền thanh toán:</strong> {{ number_format($totalPayment + $shipping_array['fee_ship'], 0, ',', '.') }}
        VNĐ <!-- Hiển thị tổng tiền thanh toán -->

        <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi.</p>
        <p>Trân trọng</p>
       <p style="text-align: center">Xem lịch sử đơn hàng:<a target="_blank" href="{{url('/lichsudh')}}">Lịch sử đơn hàng của bạn</a></p>
    </div>
</body>
