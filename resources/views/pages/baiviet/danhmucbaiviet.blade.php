@extends('layout')
@section('slider')
    @include('pages.include.slider');
@endsection
@section('content_xemnhieu')
    <div class="features_items">
        <h2 class="title text-center">{{$meta_title}}</h2>
        <div class="product-image-wrapper" style="border: none">
            @foreach ($baiviett as $key => $p)
                <div class="single-products" style="margin: 10px 0;padding:2px">
                    <div class="text-center">

                        <img style="float: left;width:30%;padding:5px;height:150px"
                            src="{{ URL::to('public/uploads/post/' . $p->baiviet_image) }}" alt="{{ $p->baiviet_slug }}" />
                        <h4 style="color: red;padding:5px;">{{ $p->baiviet_title }}</h4>
                        <p>{!! $p->baiviet_desc !!}</p>

                    </div>
                    <div class="text-right">
                        <a href="{{url('/bai-viet',$p->baiviet_slug)}}" class="btn btn-default add-to-cart">Xem bài viết</a>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
    <style>
        /* CSS for product image */
.single-products img {
    float: left;
    width: 30%;
    padding: 5px;
    height: 150px;
}

/* CSS for product title */
.single-products h4 {
    color: #333; /* Màu chính cho tiêu đề */
    padding: 5px;
    font-size: 18px;
}

/* CSS for product description */
.single-products p {
    font-size: 16px;
    line-height: 1.5;
    color: #666; /* Màu chính cho mô tả */
}

/* CSS for "Xem bài viết" button */
.single-products .btn {
    margin-top: 10px;
    background-color: #007bff; /* Màu chính cho nút */
    color: #fff;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    text-transform: uppercase;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.single-products .btn:hover {
    background-color: #0056b3; /* Màu khi di chuột qua nút */
}

/* CSS for container of products */
.product-image-wrapper {
    border: none;
}

/* CSS for section title */
.title {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333; /* Màu chính cho tiêu đề section */
    text-transform: uppercase;
}

/* CSS for centering text */
.text-center {
    text-align: center;
}

/* CSS for right aligning text */
.text-right {
    text-align: right;
}

/* Clearfix for floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Responsive styling */
@media screen and (max-width: 768px) {
    .single-products img {
        width: 100%;
        height: auto;
        float: none;
        margin-bottom: 10px;
    }
}

    </style>
@endsection
