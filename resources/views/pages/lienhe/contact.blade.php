@extends('layout')
@section('content_thu2')
    <div class="features_items">
        <h2 class="title text-center">LIÊN HỆ VỚI CHÚNG TÔI</h2>
        <div class="row">
            @foreach($contact as $key =>$cont)
            <div class="col-md-12">
               {!!$cont->ct_contact!!}
               {!!$cont->ct_fanpage!!}
            </div>
            <div class="col-md-12">
               <h4>Bản đồ</h4>
               {!!$cont->ct_map!!}
            </div>
            @endforeach
        </div>
       
    </div>
@endsection

