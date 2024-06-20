<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gui mail GG</title>
    <style type="text/css">
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.coupon {
    padding: 20px;
    border-radius: 10px;
    background-color: #ffffff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.coupon h2 {
    color: #ff0000;
    /* Màu đỏ nhấn nhá */
}

.promo {
    margin-top: 20px;
}

.code {
    color: #ff0000;
    /* Màu đỏ nhấn nhá */
    font-weight: bold;
}

.expiration {
    font-style: italic;
    color: #ff0000;
    /* Màu đỏ nhấn nhá */
}

.description {
    margin-top: 20px;
}

.shop-link {
    margin-top: 20px;
}

.shop-link a {
    color: #007bff;
    text-decoration: none;
}

.shop-link a:hover {
    text-decoration: underline;
}

    </style>

</head>

<body>
    <div class="container">
        <div class="coupon">
            <h2>🎉 Mã Khuyến Mãi từ Shop Vulinh.com</h2>
            <p>Chào bạn,</p>
            <p>Bạn đã nhận được một mã khuyến mãi đặc biệt từ cửa hàng của chúng tôi!</p>
            <p>Đây là chi tiết mã khuyến mãi:</p>
            <div class="promo">
                <h2>
                    @if($coupon['coupon_condition'] == 1)
                    Giảm {{$coupon['coupon_number']}}%
                    @else
                    Giảm {{number_format($coupon['coupon_number'],0,',','.')}}k
                    @endif
                    cho tổng đơn đặt hàng
                </h2>
                <h3>Mã khuyến mãi: <span class="code">{{$coupon['coupon_code']}}</span> với chỉ:{{$coupon['coupon_time']}} mã</h3>
                <p>Hãy nhập mã này khi thanh toán để nhận ưu đãi đặc biệt!</p>
                <p class="expiration">⏳ Ngày bắt đầu: {{$coupon['start']}} | Ngày kết thúc: {{$coupon['end']}} </p>
            </div>
            <p class="description">Đừng bỏ lỡ cơ hội để sở hữu những sản phẩm tuyệt vời với mức giá ưu đãi chỉ có trong
                thời gian giới hạn này!</p>
            <p class="shop-link">Đặt hàng ngay tại <a href="http://localhost/laravel_shopTMDT/"
                    target="_blank">Vulinh.com</a> và trải nghiệm mua sắm thú vị ngay bây giờ!</p>
        </div>
    </div>
</body>

</html>
