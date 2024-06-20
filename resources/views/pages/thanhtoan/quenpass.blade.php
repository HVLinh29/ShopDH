@extends('layout')
@section('content')
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-sm-offset-1">
                    @if (session()->has('message'))
                    <div class="alert alert-success">
                        {!! session()->get('message') !!}
                    </div>
                @elseif(session()->has('error'))
                    <div class="alert alert-danger">
                        {!! session()->get('error') !!}
                    </div>
                @endif
                
                    <div class="login-form">
                        <h2>Nhập Email lấy Pass</h2>
                        <form action="{{ url('/recover-pass') }}" method="POST">
                            @csrf
                            <input type="text" name="email_account" placeholder="Nhập Email" />


                            <button type="submit" class="btn btn-success">Gửi</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
