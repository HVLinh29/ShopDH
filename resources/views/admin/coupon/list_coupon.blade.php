@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
       Liệt kê mã giảm giá
      </div>
     
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <style>
            .custom-button {
                background-color: brown;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 5px 2px;
                cursor: pointer;
                border: none;
                border-radius: 4px;
            }
            span.dt-column-title {
                font-size: large;
            }
        </style>
        <a href="{{ URL::to('/insert-coupon') }}" class="custom-button" >Thêm mã giảm giá</a>
          <?php
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">'.$message.'</span>';
              Session::put('message',null);
          }
          ?>
          <thead>
            <tr>
            
              <th style="color: brown">Tên mã giảm giá</th>
              <th style="color: brown">Mã giảm giá</th>
              <th style="color: brown">Số lượng mã</th>
              <th style="color: brown">Diều kiện giảm giá</th>
              <th style="color: brown">Số lượng</th>
              <th style="color: brown">Ngày bắt đầu</th>
              <th style="color: brown">Ngày kết thúc</th>
              <th style="color: brown">Tình trạng</th>
              <th style="color: brown">Hết hạn</th>
              <th style="color: brown">Gửi mã</th>
              <th style="color: brown">Quản lý</th>
            
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($coupon as $key =>$cou)
            <tr>
              <td>{{$cou->coupon_name}}</td>
              <td>{{$cou->coupon_code}}</td>
              <td>{{$cou->coupon_time}}</td>
              <td><span class="text-ellipsis">
                <?php
                  if($cou->coupon_condition==1){
                  ?>
                   Giảm theo %
                <?php
                  }else{
                   ?>
                    Giảm theo tiền
                    <?php
                  }

                ?>
              </span>
            </td>
            <td><span class="text-ellipsis">
                <?php
                  if($cou->coupon_condition==1){
                  ?>
                    Giảm {{$cou->coupon_number}} %
                <?php
                  }else{
                   ?>
                    Giảm {{$cou->coupon_number}} k
                    <?php
                  }

                ?>
              </span></td>
              <td>{{$cou->coupon_date_start}}</td>
              <td>{{$cou->coupon_date_end}}</td>
              <td><span class="text-ellipsis">
                <?php
                  if($cou->coupon_status==1){
                  ?>
                    Đang kích hoạt
                <?php
                  }else{
                   ?>
                   Đã khóa
                    <?php
                  }

                ?>
              </span></td>
              <td>
              
                  @if($cou->coupon_date_end > $today)
                  <span style="color:red">Còn hạn</span>
                  @else 
                  <span style="color:green">Đã hết hạn</span>
                  @endif
              </td>
              <td>
                <p><a href="{{ url('/send-coupon-vip', [
                  
                  'coupon_time' => $cou->coupon_time,
                  'coupon_condition' => $cou->coupon_condition, // Thêm dấu phẩy ở đây
                  'coupon_number' => $cou->coupon_number,
                  'coupon_code' => $cou->coupon_code
              ]) }}" class="btn btn-success">Gửi mã VIP</a></p><br>
              <p><a href="{{ url('/send-coupon', [
                  
                  'coupon_time' => $cou->coupon_time,
                  'coupon_condition' => $cou->coupon_condition, // Thêm dấu phẩy ở đây
                  'coupon_number' => $cou->coupon_number,
                  'coupon_code' => $cou->coupon_code
              ]) }}" class="btn btn-success">Gửi mã thường</a></p>
              
              </td>
              <td>
                <a onclick="return confirm('Bạn có muốn xóa mã giảm giá này?')" href="{{URL::to('/delete-coupon/'.$cou->coupon_id)}}"
                   class="active btn btn-danger" ui-toggle-class="">
                 Xóa</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
    </div>
  </div>
@endsection