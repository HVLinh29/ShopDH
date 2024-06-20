<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập AUTH</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .log-w3 {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px #0000001f;
            max-width: 400px;
            margin: 100px auto;
            padding: 40px;
        }
        .log-w3 h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }
        .log-w3 form input[type="text"],
        .log-w3 form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-bottom: 1px solid #ddd;
            background: transparent;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            outline: none;
        }
        .log-w3 form input[type="text"]:focus,
        .log-w3 form input[type="password"]:focus {
            border-bottom: 1px solid #007bff;
        }
        .log-w3 form input[type="submit"] {
            background: #007bff;
            color: #fff;
            padding: 15px 0;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .log-w3 form input[type="submit"]:hover {
            background: #0056b3;
        }
        .log-w3 .forgot a {
            color: #555;
            text-decoration: none;
        }
        .log-w3 .forgot a:hover {
            text-decoration: underline;
        }
        .log-w3 .divider {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .log-w3 .divider hr {
            border: none;
            background: #ddd;
            height: 1px;
            width: 30%;
            display: inline-block;
            margin: 0;
        }
        .log-w3 .divider p {
            color: #888;
            margin: 0 10px;
            display: inline-block;
        }
        .log-w3 .social-login {
            text-align: center;
        }
        .log-w3 .social-login a {
            color: #fff;
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 50%;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        .log-w3 .social-login a:hover {
            opacity: 0.9;
        }
        .log-w3 .social-login .facebook {
            background: #3b5998;
        }
        .log-w3 .social-login .twitter {
            background: #00aced;
        }
        .log-w3 .social-login .google {
            background: #dd4b39;
        }
        .log-w3 .text-alert {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="log-w3">
        <h2>ĐĂNG NHẬP AUTH</h2>
        @php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert">'.$message.'</span>';
                Session::put('message',null);
            }
        @endphp
        <form action="{{URL::to('/login')}}" method="post">
            {{csrf_field()}}
            @foreach($errors->all() as $val)
                <ul>
                    <li>{{$val}}</li>
                </ul>
            @endforeach
            <div class="form-group">
                <input type="text" class="form-control" name="admin_email" placeholder="Nhập Email" required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="admin_password" placeholder="Nhập Password" required="">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary btn-block" value="ĐĂNG NHẬP">
            </div>
            <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div>
            <br/>
            @if($errors->has('g-recaptcha-response'))
                <span class="invalid-feedback" style="display:block">
                        <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                    </span>
            @endif
        </form>
        <div class="social-login">
            <a href="{{url('/login-google')}}" class="btn btn-primary facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="btn btn-info twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="btn btn-danger google"><i class="fab fa-google"></i></a>
        </div>
        <div class="divider">
            <hr>
            <p>Hoặc đăng nhập bằng</p>
            <hr>
        </div>  
        <p class="forgot"><a href="#">Quên mật khẩu?</a></p>
        <a href="{{url('/register-auth')}}" class="btn btn-success btn-block"><i class="fa fa-user-plus"></i> Đăng kí phân quyền</a>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
