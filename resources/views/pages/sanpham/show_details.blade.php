@extends('layout')

@section('content_thu2')
    @foreach ($product_details as $key => $value)
        <div class="product-details"><!--product-details-->
            <style>
                .lSSlideOuter .lSPager.lSGallery img {
                    display: block;
                    height: 140px;
                    max-width: 100%;
                }
            </style>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: none">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ url('/danh-muc-san-pham/' . $cate_slug) }}">{{ $product_cate }}</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">{{ $meta_title }}</li>

                </ol>
            </nav>
            <div class="col-sm-5">
                <ul id="imageGallery">
                    @foreach ($gallery as $key => $gal)
                        <li data-thumb="{{ asset('public/uploads/gallery/' . $gal->g_image) }}"
                            data-src="{{ asset('public/uploads/gallery/' . $gal->g_image) }}">
                            <img style="margin-top: 24px;" width="100%" alt="{{ $gal->g_name }}"
                                src="{{ asset('public/uploads/gallery/' . $gal->g_image) }}" />

                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-7">
                <div class="product-information"><!--/product-information-->
                    <h2 style="color: red;">{{ $value->product_name }}</h2>
                    <div style="display: flex; align-items: center;">
                        <ul style="width: 60%;" class="list-inline rating" title="Average Rating">
                            <a style="color: red; font-size: 17px;">{{ $rating }}*</a>
                            @for ($count = 1; $count <= 5; $count++)
                                @php
                                    if ($count <= $rating) {
                                        $color = 'color:#ffcc00;';
                                    } else {
                                        $color = 'color:#ccc;';
                                    }
                                @endphp
            
                                <li title="star_rating" class="rating" style="{{ $color }} font-size: 20px;">&#9733;</li>
                            @endfor
                            <a style="color: black;font-size:17px">({{$ratingCount}})</a>
                        </ul>
                        
                    </div>
                    @if ($value->product_km != 0)
                        <div>
                            <h5 style="display: inline; text-decoration: line-through;">
                                {{ number_format($value->product_km, 0, ',', '.') }} VNĐ
                            </h5>
                            <h4 style="display: inline;color:red">
                                {{ number_format($value->product_price, 0, ',', '.') }} VNĐ</h4>
                        </div>
                    @else
                        <h4 style="color: red;">
                            {{ number_format($value->product_price, 0, ',', '.') }} VNĐ
                        </h4>
                    @endif

                    @if ($value->product_km != 0)
                        <h5 style="color:white" class="discount-badge">
                            Giảm: {{ round((($value->product_km - $value->product_price) / $value->product_km) * 100) }}%
                        </h5>
                    @endif
                    <h5 style="color: brown">
                        Đã bán: {{ $value->product_sold }} || Đã xem {{ $value->product_view }}
                    </h5>
                    <form action="{{ URL::to('/save-cart') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $value->product_id }}"
                            class="cart_product_id_{{ $value->product_id }}">
                        <input type="hidden" value="{{ $value->product_name }}"
                            class="cart_product_name_{{ $value->product_id }}">
                        <input type="hidden" value="{{ $value->product_image }}"
                            class="cart_product_image_{{ $value->product_id }}">
                        <input type="hidden" value="{{ $value->product_quantity }}"
                            class="cart_product_quantity_{{ $value->product_id }}">
                        <input type="hidden" value="{{ $value->product_price }}"
                            class="cart_product_price_{{ $value->product_id }}">

                        <div class="mb-3 d-flex align-items-center">
                            <label for="qty" style="font-size: 18px; margin-right: 10px;">Số lượng:</label>
                            <input style="margin-bottom: 10px" type="number" name="qty" id="qty"
                                class="form-control cart_product_qty_{{ $value->product_id }}" value="1"
                                min="1" style="width: 100px;">
                            <input type="hidden" name="productid_hidden" value="{{ $value->product_id }}">
                            <button type="button" class="btn btn-default add-to-cart ml-3"
                                data-id_product="{{ $value->product_id }}" name="add-to-cart">
                                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ hàng
                            </button>
                        </div>
                    </form>

                    <p><b>Tình trạng:@php
                        if ($value->product_quantity == 0) {
                            echo ' Hết hàng';
                        } else {
                            echo ' Còn hàng';
                        }
                    @endphp</p>
                    <p><b>Điều kiện:</b> Mới 100%</p>
                    <p><b>Số lượng kho còn:</b> {{ $value->product_quantity }}</p>
                    <p><b>Thương hiệu:</b> {{ $value->tenthuonghieu }}</p>
                    <p><b>Danh mục:</b> {{ $value->tendanhmuc }}</p>
                    <a href="#"><img src="images/product-details/share.png" class="share img-responsive"
                            alt="" /></a>

                    <fieldset>
                        <legend>Tags</legend>
                        <p><i class="fa fa-tag"></i>
                            @php
                                $tags = $value->product_tags;
                                $tags = explode(',', $tags);
                            @endphp

                            @foreach ($tags as $tag)
                                <a href="{{ url('/tag/' . str_slug($tag)) }}"
                                    class="badge badge-primary">{{ $tag }}</a>
                            @endforeach
                        </p>
                    </fieldset>
                </div><!--/product-information-->
            </div>
        </div>
    @endsection
    @section('content_soluong')
        <div class="category-tab shop-details-tab">
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li><a href="#details" data-toggle="tab">Mô tả</a></li>
                    <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                    <li class="active"><a href="#reviews" data-toggle="tab">Đánh giá</a></li>


                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane" id="details">
                    <p>{!! $value->product_desc !!}</p>
                </div>

                <div class="tab-pane fade" id="companyprofile">
                    <p>{!! $value->product_content !!}</p>
                </div>
                <div class="tab-pane fade active in" id="reviews">
                    <div class="col-sm-12">

                        <style>
                            .style_comment {
                                border: 1px solid #ddd;
                                border-radius: 10px;
                                background: #F0F0E9
                            }
                        </style>
                        
                        <p><b>Đánh giá sản phẩm </b></p>
                        {{-- Danh gia sao --}}
                        <div style="display: flex; align-items: center;">
                            <ul style="width: 80%;" class="list-inline rating" title="Average Rating"
                                style="margin-right: 10px;">
                                @for ($count = 1; $count <= 5; $count++)
                                    @php
                                        if ($count <= $rating) {
                                            $color = 'color:#ffcc00;';
                                        } else {
                                            $color = 'color:#ccc;';
                                        }
                                    @endphp

                                    <li title="star_rating" id="{{ $value->product_id }}-{{ $count }}"
                                        data-index="{{ $count }}" data-product_id="{{ $value->product_id }}"
                                        data-rating="{{ $rating }}" class="rating"
                                        style="cursor:pointer;{{ $color }} font-size:30px;">&#9733;</li>
                                @endfor
                                <a style="color: red;font-size:24px;">({{ $rating }}*)</a>
                            </ul>
                            <span>Số lượt đánh giá: {{ $ratingCount }}</span>
                        </div>
                        <p><b>Bình luận về sản phẩm</b></p>
                       
                        <div class="comment-section">
                            <form action="#">
                                <span>
                                    <input type="hidden" class="cmt_name" placeholder="User"
                                           value="{{ Session::get('customer_name', '') }}"
                                           {{ Session::has('customer_name') ? 'readonly' : '' }} />
                                </span>
                                <input name="cmt" class="comment_content" placeholder="Bình luận"></input>
                                <div id="notify_comment"></div>
                                @if (!Session::get('customer_name', ''))
                                    <button type="button" class="btn btn-danger send-comment">Đăng nhập để bình luận</button>
                                @else
                                    <button type="button" class="btn btn-danger send-comment">Gửi bình luận</button>
                                @endif
                            </form>
                          
                        </div>
                        <div>
                        <form>
                            @csrf
                            <input type="hidden" name="cmt_pr_id" class="cmt_pr_id"
                                value="{{ $value->product_id }}">
                            <div id="comment_show"></div>

                        </form>
                        <div>
                    </div>
                </div>



            </div>
        </div>
    @endforeach
@endsection
@section('content_xemnhieu')
    <div class="recommended_items">
        <h2 class="title text-center">Sản phẩm liên quan</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    
                    @foreach ($splienquan as $key => $product)
                        <a href="{{ URL::to('chi-tiet-san-pham/' . $product->product_slug) }}">
                            <div class="col-md-3">
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
                                            <p style="margin-top: 15px;color:brown">Đã bán:{{ $product->product_sold }}
                                            </p>
                                            <input type="button" style="margin-bottom: 15px" value="Xem sản phẩm"
                                                class="btn btn-danger btn-sm add-to-cart"
                                                data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach



                </div>

            </div>

        </div>
    </div>
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

    .add-to-cart {
        border-radius: 50%;
        background-color: #000;
        color: #fff;
        padding: 10px;
        transition: background-color 0.3s ease;
        border: none;
        overflow: hidden;
        /* Giữ cho phần bên ngoài khu vực hình tròn bị ẩn đi */
    }

    .add-to-cart:hover {
        background-color: #333;
        transform: scale(1.1);
        /* Phóng to khi di chuột vào */
    }

    /* CSS cho phần product-information */
    .product-information {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;

    }

    .product-information h2 {
        font-size: 24px;
        margin-top: 0;
    }

    .product-information img.newarrival {
        position: absolute;
        width: 60px;
        margin-left: -10px;
        margin-top: -10px;
    }

    .product-information p {
        font-size: 16px;
    }

    .product-information label {
        font-weight: bold;
        margin-right: 10px;
    }

    .product-information input[type="number"] {
        width: 60px;
        margin-right: 10px;
    }

    .product-information button.add-to-cart {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 8px 20px;
        font-size: 16px;
        cursor: pointer;
    }

    .product-information button.add-to-cart:hover {
        background-color: #0056b3;
    }

    .product-information fieldset {
        margin-top: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
    }

    .product-information fieldset legend {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .product-information fieldset p {
        margin-bottom: 5px;
    }

    .product-information a.share {
        margin-top: 20px;
        display: block;
    }

    .product-information a.badge {
        margin: 3px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;

    }
    comment-section {
    display: flex;
    align-items: flex-start;
    margin: 20px;
}

form {
    display: flex;
    flex-direction: column;
    width: 50%;
    margin-right: 20px;
}

.comment_content {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.send-comment {
    align-self: flex-end;
    padding: 10px 20px;
    background-color: #d9534f;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.send-comment:hover {
    background-color: #c9302c;
}

</style>

