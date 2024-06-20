@extends('layout')
@section('slider')
    @include('pages.include.slider');
@endsection
@section('content_thu2')
    <div class="features_items">
        @foreach ($brand_name as $key => $name)
            <h2 class="title text-center">Thương hiệu: {{ $name->tenthuonghieu }}</h2>
            <div class="row">
                @foreach ($brand_by_id as $key => $product)
                    <div class="col-md-3">
                        <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <div class="position-relative">
                                            <img id="wishlist_productimage{{ $product->product_id }}"
                                                src="{{ URL::to('public/uploads/product/' . $product->product_image) }}"
                                                alt="" />
                                            @if ($product->product_km != 0)
                                                <a style="color:white" class="discount-badge">
                                                    -{{ round((($product->product_km - $product->product_price) / $product->product_km) * 100) }}%
                                                </a>
                                            @endif
                                            </div>
                                        <p style="margin-top: 20px">{{ $product->product_name }}</p>
                                        @if ($product->product_km != 0)
                                            <div>
                                                <h5 style="display: inline; text-decoration: line-through;">
                                                    {{ number_format($product->product_km, 0, ',', '.') }} VNĐ
                                                </h5>
                                                <h4 style="display: inline;color:red">
                                                    {{ number_format($product->product_price, 0, ',', '.') }} VNĐ</h4>
                                            </div>
                                        @else
                                            <h4 style="color: red;">
                                                {{ number_format($product->product_price, 0, ',', '.') }} VNĐ
                                            </h4>
                                        @endif
                                        <p style="margin-top: 15px;color:brown">Đã bán:{{ $product->product_sold }}</p>
                                        <input type="button" value="Xem sản phẩm" class="btn btn-danger btn-sm add-to-cart"
                                    data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                    </div>  
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    <div class="fb-comments" data-href="http://vulinh.com/laravel_shopTMDT/danh-muc-san-pham/4" data-width=""
        data-numposts="20"></div>
@endsection
<style>
    .position-relative {
        position: relative;
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: red;
        color: white;
        padding: 5px;
        border-radius: 5px;
    }

    .product-image-wrapper {
        margin-bottom: 20px;
        border-radius: 10px;
        /* Bo tròn góc */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Đổ bóng */
        transition: transform 0.3s ease;
        /* Thêm hiệu ứng chuyển đổi */
    }

    .product-image-wrapper:hover {
        transform: scale(1.05);
        /* Phóng to 5% khi di chuột vào */
    }

    .productinfo {
        position: relative;
    }

    .productinfo h2 {
        font-size: 18px;
        margin-top: 10px;
    }

    .productinfo p {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .add-to-cart:hover {
        background-color: #E58E0B;
        /* Màu nền khi hover */
    }

    /* CSS cho nút yêu thích */
    .button_wishlist {
        border: none;
        background: transparent;
        color: #83AFA8;
        font-size: 14px;
        cursor: pointer;
        padding: 0;
    }

    .button_wishlist span:hover {
        color: #FE980F;
        /* Màu khi hover */
    }

    /* CSS cho nút xem nhanh */
    .choose .nav-pills li:nth-child(2) a {
        color: #ff0000;
        font-size: 14px;
        padding: 0;
    }

    .choose .nav-pills li:nth-child(2) a:hover {
        color: #FE980F;
        /* Màu khi hover */
    }

    ul.nav.nav-pills.nav-justified li {
        text-align: center;
        font-size: 13px;
    }

    .button_wishlist {
        border: none;
        background: #ffffff;
        color: #ff0000;

    }

    ul.nav.nav-pills.nav-justified i {
        color: #ff0000;
    }

    .button_wishlist span:hover {
        color: #FE980F;
    }

    .button_wishlist:focus {
        border: none;
        outline: none
    }

    .add-to-cart {
        border-radius: 20px;
        /* Đặt viền tròn */
        background-color: red;
        /* Đặt màu nền là màu đỏ */
        color: white;
        /* Đặt màu chữ là trắng */
        border: none;
        /* Loại bỏ viền */
        padding: 5px 10px;

    }

    .add-to-cart:hover {
        background-color: darkred;
        /* Đổi màu nền khi di chuột qua */
    }

    input.btn.btn-danger.btn-sm.add-to-cart {
        margin-bottom: 10px;
    }

    /* Định dạng sản phẩm */
    .col-md-3 {
        width: 25%;
        /* Sử dụng 25% chiều rộng của container cha */
        float: left;
        /* Float để các cột nằm cạnh nhau */
        box-sizing: border-box;
        /* Không tính padding và border vào kích thước của cột */
        padding: 0 15px;
        /* Khoảng cách giữa các cột */
    }
</style>
@section('footer')
    @include('pages.include.footer');
@endsection
