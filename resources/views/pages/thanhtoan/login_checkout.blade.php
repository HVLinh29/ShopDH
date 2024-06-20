@extends('layout')

@section('content_thu2')
<section id="form"><!--form-->
    <div class="container">
        <div class="row"> <!-- Thêm lớp justify-content-center để căn giữa nội dung -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <h2 class="text-center">Đăng nhập tài khoản</h2>
                        <form action="{{ URL::to('/login-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"  name="email_account" class="form-control" id="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" name="password_account" class="form-control" id="password" placeholder="Mật khẩu" required>
                            </div>
                            <div class="mb-3 form-check">
                                <a href="{{ URL::to('/quen-mk') }}" class="form-check-label">Quên mật khẩu</a>
                            </div>
                            <!-- Sử dụng d-grid để căn giữa nút Đăng nhập -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-success btn-lg">Đăng nhập</button>
                            </div>
                            <p class="text-center">Bạn chưa có tài khoản? <a href="{{ URL::to('/dang-ki') }}">Đăng ký ngay</a></p>
                        </form>
                        <hr>
                        <div class="text-center">
                            <p>Hoặc đăng nhập bằng:</p>
                            <a href="{{ url('customer-gg') }}" class="btn btn-primary"><img width="20" alt="Đăng nhập Google" src="{{ asset('public/fontend/images/gg.png') }}"> Google</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .row{
                display: flex;
    justify-content: center;
            }
        </style>
    </div>
</section>
@endsection
