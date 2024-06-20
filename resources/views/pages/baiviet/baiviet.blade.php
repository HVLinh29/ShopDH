@extends('layout')
@section('slider')
    @include('pages.include.slider');
@endsection
@section('content_xemnhieu')
<style type="text/css">
    .baiviet ul li{
        padding: 2px;
        font-size: 16px
    }
    .baiviet ul li a{
        color: #000;
        text-decoration: none;
    }
    .baiviet ul li a:hover{
        color: #FE980F;
    }
    .baiviet ul li{
        list-style-type: decimal-leading-zero;
    }
    .mucluc h1{
        font-size: 20px;
        color: brown
    }
</style>
    <div class="features_items">
        <h2 style="margin: 0;position:inherit;font-size:22px" class="title text-center">{{$meta_title}}</h2>
        <div class="product-image-wrapper" style="border: none">
            @foreach ($baiviett as $key => $p)
                <div class="single-products" style="margin: 10px 0;padding:2px">
                    {!!$p->baiviet_content!!}
                </div>
            @endforeach
        </div>
    </div>
    <h2 style="margin:0;font-size:22px" class="title text-center">BÀI VIẾT LIÊN QUAN</h2>
    <style type="text/css">
        ul.post_relate li{
            list-style-type: disc;
            font-size: 16px;
            padding: 6px
        }
        ul.post_relate li a{
            color: #000
        }
        ul.post_relate li a:hover{
            color: brown
        }
        </style>
    <ul class="post_relate">
        @foreach ($related as $key => $post_relate)
            <li>
                <a href="{{URL::to('bai-viet/'.$post_relate->baiviet_slug)}}">
                    {{ $post_relate->baiviet_title }}</h4>
                </a>
            </li>
        @endforeach
    </ul>
@endsection
