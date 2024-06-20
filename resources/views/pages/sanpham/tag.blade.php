@extends('layout')
@section('content')
    <div class="features_items">
        <h2 class="title text-center">Tag Sản Phẩm: {{$product_tag}}</h2>
        <div class="row"> <!-- Thêm lớp row ở đây -->
        @foreach ($pro_tag as $key => $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                @csrf
                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                            <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                            <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" 
                            class="cart_product_price_{{$product->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">
                            <a id="wishlist_producturl{{$product->product_id}}" href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
                                <img id="wishlist_productimage{{$product->product_id}}" src="{{ URL::to('public/uploads/product/' . $product->product_image) }}" alt="" />
                                <h2 style="color: red">{{ number_format($product->product_price,0,',','.')}}đ</h2>
                                <p>{{ $product->product_name }}</p>
                            
                            </a>
                            <button type="button" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">Thêm giỏ hàng</button>
                            </form>
                        </div>

                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <style type="text/css">
                                ul.nav.nav-pills.nav-justified li{
                                    text-align: center;
                                    font-size: 13px;
                                } 
                                .button_wishlist{
                                    border: none;
                                    background: #ffffff;
                                    color: #83AFA8;

                                }
                                ul.nav.nav-pills.nav-justified i{
                                    color: #83AFA8;
                                }
                                .button_wishlist span:hover{
                                    color: #FE980F;
                                }
                                .button_wishlist:focus{
                                    border: none;
                                    outline: none
                                }
                            </style>
                            
                            <li>
                                <i class="fa fa-heart"></i>
                                <button class="button_wishlist" id="{{$product->product_id}}" onclick="add_wishlist(this.id);">
                                    <span>Yêu thích</span>
                                </button>
                            </li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>Xem nhanh</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        @endforeach
        </div>
    </div>
@endsection
<style>
 /* CSS cho sản phẩm */
.product-image-wrapper {
    margin-bottom: 20px;
}

.productinfo {
    position: relative;
}

.productinfo form {
    padding: 20px;
    background-color: #fff; /* Màu nền */
    border-radius: 10px; /* Bo tròn viền */
    box-shadow: 0px 2px 10px white; /* Hiệu ứng đổ bóng */
}

.productinfo h2 {
    font-size: 18px;
    margin-top: 10px;
}

.productinfo p {
    font-size: 16px;
    margin-bottom: 15px;
}

.add-to-cart {
    background-color: #FE980F; /* Màu nút thêm vào giỏ hàng */
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 3px;
    cursor: pointer;
}

.add-to-cart:hover {
    background-color: #E58E0B; /* Màu nền khi hover */
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
    color: #FE980F; /* Màu khi hover */
}

/* CSS cho nút xem nhanh */
.choose .nav-pills li:nth-child(2) a {
    color: #83AFA8;
    font-size: 14px;
    padding: 0;
}

.choose .nav-pills li:nth-child(2) a:hover {
    color: #FE980F; /* Màu khi hover */
}



</style>