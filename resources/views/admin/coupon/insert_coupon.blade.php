@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Thêm mã giảm giá
                </header>
                <div class="panel-body">
                    <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="POST">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên mã giảm giá</label>
                            <input type="text" class="form-control"  name="coupon_name"  id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ngày bắt đầu</label>
                            <input type="text" class="form-control" id="coupon_start" name="coupon_date_start"  id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ngày kết thúc</label>
                            <input type="text" class="form-control" id="coupon_end" name="coupon_date_end"  id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mã giảm giá</label>
                            <input type="text" class="form-control"  name="coupon_code"  id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Số lượng mã</label>
                            <input type="text" class="form-control"  name="coupon_time"  id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tính năng của mã</label>
                            <select name="coupon_condition" class="form-control input-sm m-bot15">
                                <option value="0">Chọn</option>
                                <option value="1">Giảm theo %</option>
                                <option value="2">Giảm theo số tiền</option>
                              
                            </select>                        
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nhập số % hoặc số tiền giảm</label>
                            <input type="text" class="form-control"  name="coupon_number"  id="exampleInputEmail1"> 
                        </div>
                    
                    
                        <button type="submit" name="add_coupon" class="btn btn-success">Thêm mã</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection