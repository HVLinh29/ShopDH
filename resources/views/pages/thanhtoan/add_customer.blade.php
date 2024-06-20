@extends('layout')

@section('content_thu2')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row ">
                <div class="col-sm-6">
                    <div class="signup-form">
                        <h2>Đăng ký</h2>
                        <form action="{{ URL::to('/add-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="customer_name" placeholder="Họ và tên" />
                            <input type="email" name="email" placeholder="Email" />
                            <input type="password" name="password" placeholder="Mật khẩu" />
                            <input type="text" name="phone" placeholder="Số điện thoại" />
                            <button type="submit" class="btn btn-danger ">Đăng ký</button>
                        </form>
                    </div>
                </div>
                <style>
                    .row {

                        display: flex;
                        justify-content: center;
                    }
                </style>
            </div>
    </section>
@endsection
