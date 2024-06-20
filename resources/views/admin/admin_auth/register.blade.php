<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký Admin</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet">
    <!-- Google reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .log-w3 {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px #0000001f;
            padding: 40px;
            width: 350px;
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
            padding: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background: transparent;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            outline: none;
        }
        .log-w3 form input[type="text"]::placeholder,
        .log-w3 form input[type="password"]::placeholder {
            color: #999;
        }
        .log-w3 form input[type="text"]:focus,
        .log-w3 form input[type="password"]:focus {
            border-color: #007bff;
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
        .log-w3 .form-group {
            margin-bottom: 20px;
        }
        .log-w3 .g-recaptcha {
            margin-bottom: 20px;
        }
        .log-w3 a {
            display: block;
            text-align: center;
            margin-bottom: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .log-w3 a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="log-w3">
    <h2>Đăng ký Admin</h2>
    <?php
    $message = Session::get('message');
    if($message){
        echo '<span class="text-alert">'.$message.'</span>';
        Session::put('message',null);
    }
    ?>
    <form action="{{URL::to('/register')}}" method="post">
        {{csrf_field()}}
        @foreach($errors->all() as $val)
        <ul>
        <li>{{$val}}</li>
        </ul>
        @endforeach
        <div class="form-group">
            <input type="text" class="form-control" name="admin_name" value="{{old('admin_name')}}" placeholder="Nhập Tên" required="">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="admin_email" placeholder="Nhập Email" required="">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="admin_phone" value="{{old('admin_phone')}}" placeholder="Nhập Số Điện Thoại" required="">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="admin_password" placeholder="Nhập Mật Khẩu" required="">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary btn-block" value="ĐĂNG KÝ">
        </div>
    </form>
    <a href="{{url('/login-auth')}}">Đăng nhập Auth</a>
</div>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
