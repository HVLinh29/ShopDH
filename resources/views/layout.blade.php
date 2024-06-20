<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Linh Watch</title>

    <link href="{{ asset('public/fontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('public/fontend/css/lightgallery.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('public/backend/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ 'public/fontend/images/ico/favicon.ico' }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">


</head>

<body>
    <header id="header">
        <div class="header_top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> 012345678</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> hoangvulinh2002@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div><!--/header_top-->

        <div class="header-middle"><!--header-middle-->
            <div class="container">
                <div class="row">
                   <div class="col-sm-4">
                    <div class="shop-menu pull-right">
                        
                    </div>
                   </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">

                               
                                <li><a href="{{ URL::to('/gio-hang') }}"><i style="font-size: 28px" class="fa fa-shopping-cart"></i> 
                                            <span  style="color: red;" class="show-cart"></span>
                                    </a>
                                </li>
                                @php
                                $customer_id = Session::get('customer_id');
                                $wishlistCount = $customer_id ? App\Wishlist::where('customer_id', $customer_id)->count() : 0;
                            @endphp
                            
                            @if($customer_id != NULL)
                                <li>
                                    <a href="{{ URL::to('/yeuthichhhh') }}">
                                        <i style="font-size: 28px" class="fa fa-heart" aria-hidden="true"></i>
                                        <span style="color: red" id="wishlist-count" class="badgess">{{ $wishlistCount }}</span>
                                    </a>
                                </li>
                            @endif
                            
                                
                            <?php
                            $customer_id = Session::get('customer_id');
                            $shipping_id = Session::get('s_id');
                            if($customer_id!=NULL && $shipping_id==NULL ){
                            ?>
                            <li><a href="{{ URL::to('/thanhtoan') }}"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Thanh
                                    toán</a></li>

                            <?php
                            }elseif($customer_id!=NULL && $shipping_id!=NULL ){
                            ?>
                            <li><a href="{{ URL::to('/payment') }}"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Thanh toán</a>
                            </li>

                            <?php
                            }
                            else{
                                ?>
                            <li><a href="{{ URL::to('/login-checkout') }}"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Thanh
                                    toán</a></li>

                            <?php
                            }
                            ?>
                                @php
                                        $customer_id = Session::get('customer_id');
                                        if($customer_id!=NULL){
                                            @endphp
                                <li><a href="{{ URL::to('lichsudh') }}"><i class="fa fa-list-ol" aria-hidden="true"></i> Lịch sử đơn hàng</a>
                                </li>

                                @php
                                        }
                                @endphp

                                <?php
								$customer_id = Session::get('customer_id');
								if($customer_id!=NULL){
								?>
                                <li><a href="{{ URL::to('logout-checkout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng xuất</a>
                                    <p>{{Session::get('customer_name')}}</p>
                                </li>
                                <?php
								}else{
									?>
                                <li><a href="{{ URL::to('login-checkout') }}"><i class="fa fa-user-plus" aria-hidden="true"></i> Đăng nhập</a>
                                </li>
                                <?php
								}
								?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header-middle-->

        <div class="header-bottom"><!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                       
                        <div class="mainmenu pull-left"><!-- Add text-center class here -->
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{ url('/trang-chu') }}" class="active">Trang chủ</a></li>

                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category as $key => $danhmuc)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-san-pham/' . $danhmuc->danhmuc_slug) }}">{{ $danhmuc->tendanhmuc }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Thương hiệu<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($brand as $key => $brand)
                                            <li><a
                                                    href="{{ URL::to('/thuong-hieu-san-pham/' . $brand->thuonghieu_slug) }}">{{ $brand->tenthuonghieu }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                               
                                <li class="dropdown"><a href="#">Bài viết<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category_post as $key => $danhmucbaiviet)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-bai-viet/' . $danhmucbaiviet->article_slug) }}">{{ $danhmucbaiviet->article_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                             
                                <li><a href="{{ URL::to('/lien-he') }}">Liên hệ</a></li>
                            </ul>
                        </div>
                        <div class="search_box pull-right">
                            <form method="POST" action="{{ URL::to('/tim-kiem') }}" autocomplete="off">
                                {{ csrf_field() }}
                                <input type="text" name="keywords_submit" id="keywords" placeholder="Từ khóa" />
                                <div id="search_ajax"></div>
                                <input type="submit" style="color: #000" name="search_item"
                                    class=" btn-success btn-sm" value="Tìm kiếm">
                                <style>
                                    .search_box {
                                        position: relative;
                                    }
    
                                    #search_ajax {
                                        position: absolute;
                                        top: 100%;
                                        left: 0;
                                        width: 100%;
    
                                        /* Điều chỉnh màu nền của kết quả tìm kiếm */
    
                                        z-index: 999;
                                        /* Đảm bảo kết quả tìm kiếm được hiển thị trên menu */
                                    }
    
                                    .search_box {
                                        display: flex;
                                        align-items: center;
                                    }
    
                                    .search_box input[type="text"] {
                                        flex: 1;
                                        /* Ô tìm kiếm sẽ mở rộng để lấp đầy không gian còn lại */
                                        margin-right: 10px;
                                        /* Khoảng cách giữa ô tìm kiếm và nút submit */
                                    }
    
                                    .search_box input[type="submit"] {
                                        font-size: 14px;
                                        padding: 5px 10px;
                                    }
                                </style>
                            </form>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </header>

{{-- /slider --}}
@yield('slider')
<section>
    <div class="container">
        <div class="row">
            
            <div class="col-sm-12 padding-right">

                @yield('content_kmai')

            </div>
           
        </div>
    </div>
</section>
    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-sm-12 padding-right">

                    @yield('content_thu2')

                </div>
                @yield('sliderbar')
                
                <div class="col-sm-12 padding-right">

                    @yield('content')

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-sm-12 padding-right">

                    @yield('content_soluong')

                </div>
               
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                
                <div class="col-sm-12 padding-right">

                    @yield('content_xemnhieu')

                </div>
               
            </div>
        </div>
    </section>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger
      intent="WELCOME"
      chat-title="VLinh"
      agent-id="c8ac63f0-8b2a-44ac-b959-e220da03860b"
      language-code="vi"
    ></df-messenger>

    
    
    <footer class="footer text-color-dark">
        <div class="container-fluid d-flex justify-content-center">
            <div class="row anhduoi flex-grow-1">
                
                <div class="col-md-4">
                    <div class="product-image-wrapper">
                       
                        <img src="{{asset('public/fontend/images/ap/aa.png') }}" alt="Ảnh sản phẩm">
                    </div>
                   
                    <div class="productinfo" >
                        <h3 style="color: white">Giao hàng miễn phí toàn quốc</h3>
                        <h4 style="color: white">Thanh toán khi nhận hàng</h4>
                    </div>
                </div>
               
                <div class="col-md-4">
                    <div class="product-image-wrapper">
                       
                        <img src="{{asset('public/fontend/images/ap/bb.png') }}" alt="Ảnh sản phẩm">
                    </div>
                   
                    <div class="productinfo">
                        <h3 style="color: white">Cam kết hàng chính hãng</h3>
                        <h4 style="color: white">Đền 200% nếu phát hiện hàng giả</h4>
                    </div>
                </div>
              
                <div class="col-md-4">
                    <div class="product-image-wrapper">
                       
                        <img src="{{asset('public/fontend/images/ap/cc.png') }}" alt="Ảnh sản phẩm">
                    </div>
                  
                    <div class="productinfo">
                        <h3 style="color: white">Tặng ngay Voucher giảm giá</h3>
                        <h4 style="color: white">Đặt mua để nhận voucher giảm giá 10%</h4>
                    </div>
                </div>
            </div>
        </div>
        <style>
            footer.footer.text-color-dark {
            background: #333;
            margin-top: 20px;
            margin-bottom: 20px;
            height: 170px;
            }

            .container-fluid.d-flex.justify-content-center.align-items-center {
            height: 100%;
            }

            .image-container {
    position: relative;
    max-width: 100%; /* Đảm bảo ảnh không vượt quá kích thước của trang */
}

.image-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff; /* Màu chữ trên ảnh */
    text-align: center;
    padding: 20px;
    background-color: rgba(0, 0, 0, 0.7); /* Màu nền của phần chứa văn bản */
    border-radius: 5px; /* Bo tròn các góc */
}

.image-text h2,
.image-text p,
.image-text ul {
    margin: 0;
    padding: 0;
}

.image-text ul {
    list-style-type: none;
}

            .col-md-4 {
            display: flex;
            justify-content: center;

            margin-top: 50px;
            }
            .productinfo{
            padding-left: 15px;
            }
        </style>
    </footer>
    
    <footer id="footer">
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Hỗ trợ - dịch vụ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Chính sách và hướng dẫn mua hàng trả góp</a></li>
                                <li><a href="#">Hướng dẫn mua hàng và chính sách vận chuyển</a></li>
                                <li><a href="#">Tra cứu đơn hàng</a></li>
                                <li><a href="#">Chính sách đổi mới và bảo hành</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Thông tin liên hệ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Thông tin các trang TMĐT </a></li>
                                <li><a href="#">Tra cứu bảo hành</a></li>
                                <li><a href="#">Dịch vụ sửa chữa Vũ Linh</a></li>
                                <li><a href="#">Khách hàng doanh nghiệp (B2B)</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Tổng đài</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">1234.5678</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Thanh toán miễn phí</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><img src="{{asset('public/fontend/images/logo-visa.png') }}" alt="">
                                    <img src="{{asset('public/fontend/images/logo-vnpay.png') }}" alt="">
                                </li>
                                <li><img src="{{asset('public/fontend/images/logo-samsungpay.png') }}" alt="">
                                    <img src="{{asset('public/fontend/images/logo-atm.png') }}" alt="">
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="single-widget">
                            <h2>Hình thúc vận chuyển</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><img src="{{asset('public/fontend/images/nhattin.jpg')}}" alt="">
                                    <img src="{{asset('public/fontend/images/vnpost.jpg') }}" alt="">
                                </li>
                                <li>
                                    <img src="{{asset('public/fontend/images/logo-bct.png') }}" alt="">
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>



    </footer>



    <script src="{{ asset('public/fontend/js/jquery.js') }}"></script>
    <script src="{{ asset('public/fontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/price-range.js') }}"></script>
    <script src="{{ asset('public/fontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('public/fontend/js/main.js') }}"></script>

    <script src="{{ asset('public/fontend/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('public/fontend/js/lightslider.js') }}"></script>
    <script src="{{ asset('public/fontend/js/prettify.js') }}"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/jquery-ui.min.js" async defer></script>

    
  
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
   
        <script type="text/javascript">
            $(document).ready(function() {
                load_more(); // Gọi hàm khi tài liệu được tải
            });
        
            function load_more(id ='') {
                $.ajax({
                    url: '{{ url('/load-more') }}',
                    method: 'POST',
                    headers: {//tra ve gia tri cua thuoc tinh content
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                },
                data:{id:id},
                    success: function(data) {
                        $('#load_more_button').remove();
                        $('#all_product').append(data);//them noi dung moi vao cuoi phan tu duoc chon
                        
                    }
                });
            }
            $(document).on('click', '#load_more_button',function(){
                var id = $(this).data('id');//lay id cua dâta-id
                load_more(id);
            });
        </script>
    <script type="text/javascript">
       show_cart();
            //dem so luong gio hang
            function show_cart(){
                $.ajax({
                    url: '{{ url('/show-cart') }}',
                    method: 'GET',
                    success: function(data) {
                        $('.show-cart').html(data);
                    }
                });
            }
    function Addtocart($product_id){
                var id = $product_id;
             
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();

                var _token = $('input[name="_token"]').val();
                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                } else {

                    $.ajax({
                        url: '{{ url('/add-cart-ajax') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Tiếp tục xem hoặc thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/gio-hang') }}";
                                });
                                show_cart();

                        }

                    });
                }
    }
      </script>


    <script type="text/javascript">
        $(document).ready(function() {// dom da san sang
            show_cart();
            //dem so luong gio hang
            function show_cart(){
                $.ajax({
                    url: '{{ url('/show-cart') }}',
                    method: 'GET',
                    success: function(data) {
                        $('.show-cart').html(data);
                    }
                });
            }
            $('.add-to-cart').click(function() {

                var id = $(this).data('id_product');
                // alert(id);
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();

                var _token = $('input[name="_token"]').val();
                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
                } else {

                    $.ajax({
                        url: '{{ url('/add-cart-ajax') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Tiếp tục xem hoặc thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/gio-hang') }}";
                                });
                                show_cart();

                        }

                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.choose').on('change', function() {// class choose thay doi gia tri thi se dung change
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{ url('/select-delivery-home') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.calculate_delivery').click(function() {
                var matinh = $('.city').val();
                var mahuyen = $('.province').val();
                var maxa = $('.wards').val();
                var _token = $('input[name="_token"]').val();
                if (matinh == '' && mahuyen == '' && maxa == '') {
                    alert('Làm ơn chọn để tính phí vận chuyển');
                } else {
                    $.ajax({
                        url: '{{ url('/calculate-fee') }}',
                        method: 'POST',
                        data: {
                            matinh: matinh,
                            mahuyen: mahuyen,
                            maxa: maxa,
                            _token: _token
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.send_order').click(function() {
                swal({
                        title: "Xác nhận đơn hàng",
                        text: "Đơn hàng sẽ không được hoàn trả khi đặt,bạn có muốn đặt không?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Mua hàng",

                        cancelButtonText: "Đóng,chưa mua",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var s_email = $('.s_email').val();
                            var s_name = $('.s_name').val();
                            var s_address = $('.s_address').val();
                            var s_phone = $('.s_phone').val();
                            var s_notes = $('.s_notes').val();
                            var s_method = $('.payment_select').val();
                            var order_fee = $('.order_fee').val();
                            var order_coupon = $('.order_coupon').val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/confirm-order') }}',
                                method: 'POST',
                                data: {
                                    s_email: s_email,
                                    s_name: s_name,
                                    s_address: s_address,
                                    s_phone: s_phone,
                                    s_notes: s_notes,
                                    _token: _token,
                                    order_fee: order_fee,
                                    order_coupon: order_coupon,
                                    s_method: s_method
                                },
                                success: function() {
                                    swal("Đơn hàng",
                                        "Đơn hàng của bạn đã được gửi thành công",
                                        "success");
                                }
                            });

                            window.setTimeout(function() {
                                window.location.href = "{{ url('/lichsudh') }}";
                            }, 3000);

                        } else {
                            swal("Đóng", "Đơn hàng chưa được gửi, làm ơn hoàn tất đơn hàng", "error");

                        }

                    });
            });
        });
    </script>
<script>
    function add_wishlist(product_id) {
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ url('/add-to-wishlist') }}",
            method: 'POST',
            data: {
                _token: token,
                product_id: product_id,
            },
            success: function(response) {
                if (response.wishlistCount !== undefined) {
                    $('#wishlist-count').text(response.wishlistCount);
                }
                alert(response.message);
            },
            error: function(response) {
                alert(response.responseJSON.message);
            }
        });
    }
</script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#imageGallery').lightSlider({
                gallery: true,
                item: 1,
                loop: true,
                thumbItem: 5,
                slideMargin: 0,
                enableDrag: false,
                currentPagerPosition: 'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });
        });
    </script>
    
    <script type="text/javascript">
        $('#keywords').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/autocomplete-ajax') }}',
                    method: "POST",

                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });
            } else {
                $('#search_ajax').fadeOut();
            }
        });
        $(document).on('click', 'li', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        })
    </script>
     <script type="text/javascript">
     function Xemnhanh(id){
        var product_id = id;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/quickview') }}',
                method: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#product_quickview_title').html(data.product_name);//cap nhat thanh gia tri cua thuoc tinh product name.
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_gallery').html(data.product_gallery);
                    $('#product_quickview_desc').html(data.product_desc);
                    $('#product_quickview_content').html(data.product_content);
                    $('#product_quickview_value').html(data.product_quickview_value);
                    $('#product_quickview_button').html(data.product_button);


                }
            });
     }
     </script>
    <script type="text/javascript">
        $('.xemnhanh').click(function() {
            var product_id = $(this).data('id_product');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ url('/quickview') }}',
                method: "POST",
                dataType: "JSON",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#product_quickview_title').html(data.product_name);
                    $('#product_quickview_price').html(data.product_price);
                    $('#product_quickview_image').html(data.product_image);
                    $('#product_quickview_id').html(data.product_id);
                    $('#product_quickview_gallery').html(data.product_gallery);
                    $('#product_quickview_desc').html(data.product_desc);
                    $('#product_quickview_content').html(data.product_content);
                    $('#product_quickview_value').html(data.product_quickview_value);
                    $('#product_quickview_button').html(data.product_button);


                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.add-to-cart-quickview', function() {

            var id = $(this).data('id_product');
            
            var cart_product_id = $('.cart_product_id_' + id).val();
            var cart_product_name = $('.cart_product_name_' + id).val();
            var cart_product_image = $('.cart_product_image_' + id).val();
            var cart_product_quantity = $('.cart_product_quantity_' + id).val();
            var cart_product_price = $('.cart_product_price_' + id).val();
            var cart_product_qty = $('.cart_product_qty_' + id).val();

            var _token = $('input[name="_token"]').val();
            if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                alert('Làm ơn đặt nhỏ hơn ' + cart_product_quantity);
            } else {

                $.ajax({
                    url: '{{ url('/add-cart-ajax') }}',
                    method: 'POST',
                    data: {
                        cart_product_id: cart_product_id,
                        cart_product_name: cart_product_name,
                        cart_product_image: cart_product_image,
                        cart_product_price: cart_product_price,
                        cart_product_qty: cart_product_qty,
                        _token: _token,
                        cart_product_quantity: cart_product_quantity
                    },
                    beforeSend: function() {// 1 ham callback de thong bao
                        $("#beforesend_quickview").html(
                            "<p class='text text-primary'>Đang thêm sản phẩm vào giỏ hàng</p>");
                    },
                    success: function() {
                        $("#beforesend_quickview").html(
                            "<p class='text text-success'>Đã thêm sản phẩm vào giỏ hàng</p>");
                    }

                });
            }
        });
        $(document).on('click', '.redirect-cart', function() {
            window.location.href = "{{ url('/gio-hang') }}";
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            load_comment();

            function load_comment() {
                var product_id = $('.cmt_pr_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/load-comment') }}',
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        _token: _token,
                    },
                    success: function(data) {
                        $('#comment_show').html(data);
                    }

                });
            }
            $('.send-comment').click(function() {
                var product_id = $('.cmt_pr_id').val();
                var cmt_name = $('.cmt_name').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{ url('/send-comment') }}',
                    method: 'POST',
                    data: {
                        product_id: product_id,
                        cmt_name: cmt_name,
                        comment_content: comment_content,
                        _token: _token,
                    },
                    success: function(data) {

                        $('#notify_comment').html(
                            '<span class="text text-success">Đã thêm bình luận</span>'
                        )
                        load_comment();
                        $('#notify_comment').fadeOut(5000);

                        $('.cmt_name').val('');
                        $('.comment_content').val('');
                    }

                });
            });
        });
    </script>
   
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sort').on('change', function() { // fix syntax error here
                var url = $(this).val();
                if (url) {
                    window.location = url;
                } else {
                    return false;
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#slider-range").slider({
                orientation: "horizontal",
                range: true,
                min: {{ $min_price }},
                max: {{ $max_price }},
                step: 10000, // Adjust the step size according to your needs
                values: [{{ $min_price }}, {{ $max_price }}],
                slide: function(event, ui) {
                    // Format the price range with commas for better readability
                    $("#amount").val(formatCurrency(ui.values[0]) + " - " + formatCurrency(ui.values[
                        1]));
                    $("#start_price").val(ui.values[0]);
                    $("#end_price").val(ui.values[1]);
                }
            });

            // Function to format currency with commas
            function formatCurrency(value) {
                return "đ" + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Set initial price range value
            $("#amount").val(formatCurrency($("#slider-range").slider("values", 0)) + " - " + formatCurrency($(
                "#slider-range").slider("values", 1)));
        });
    </script>
     <script type="text/javascript">
        function huydh(id){
            var order_code = id;
            var lydohuy = $('.lydohuy').val();
          
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ url('huy-don-hang') }}",
                method: 'POST',
                data: {
                    order_code:order_code,
                    lydohuy:lydohuy,
                   
                    _token: _token
                },
                success: function(data) {
                   alert('Hủy đơn hàng thành công');
                   location.reload();

                }
            });
        }
    </script>
    <script type="text/javascript">
        function remove_background(product_id) {
            for (var count = 1; count <= 5; count++) {
                $('#' + product_id + '-' + count).css('color', '#ccc');
            }
        }
        //hover chuột đánh giá sao
        $(document).on('mouseenter', '.rating', function() {
            var index = $(this).data("index"); //3
            var product_id = $(this).data('product_id'); //13

            remove_background(product_id);
            for (var count = 1; count <= index; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });
        //nhả chuột ko đánh giá
        $(document).on('mouseleave', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data('product_id');
            var sosao = $(this).data("sosao");
            remove_background(product_id);
            //alert(rating);
            for (var count = 1; count <= sosao; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });
        
        $(document).on('click', '.rating', function() {
    var index = $(this).data("index"); 
    var product_id = $(this).data('product_id'); 
    var _token = $('meta[name="csrf-token"]').attr('content');

    console.log('Index:', index, 'Product ID:', product_id, 'Token:', _token); // Log to verify data

    $.ajax({
        url: "{{ url('insert-rating') }}",
        method: 'POST',
        data: {
            index: index,
            product_id: product_id,
            _token: _token
        },
        success: function(data) {
            console.log('Response Data:', data); // Log the response data

            if (data.message === 'done') {
                alert("Bạn đã đánh giá " + index + " trên 5");
                location.reload();
            } else {
                alert("Bạn chưa đánh giá");
            }
        },
        
    });
});

    </script>
</body>

</html>
