@extends('layout')
@section('content')

<div class="features_items">
    <h2 class="title text-center">Kết quả tìm kiếm</h2>
    @foreach($search_product as $key =>$product)
    <a href="{{URL::to('chi-tiet-san-pham/'.$product->product_slug)}}">
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                    <div class="productinfo text-center">
                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                        <h2>{{number_format($product->product_price).' '.'VND'}}</h2>
                        <p>{{$product->product_name}}</p>
                        <input type="button" value="Xem sản phẩm" class="btn btn-danger btn-sm add-to-cart" data-id_product="{{$product->product_slug}}" name="add-to-cart">
                    </div>
                   
            </div>
            
        </div>
    </div>
    </a>
    @endforeach
</div>


@endsection