@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                Thêm Slider
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
                        <form role="form" action="{{URL::to('/insert-slider')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên Slider</label>
                            <input type="text" class="form-control"  name="slider_name"  id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hinh anh</label>
                            <input type="file" class="form-control"  name="slider_image"  id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea style="resize: none"rows="5"  name="slider_desc" class="form-control" id="exampleInputPassword1" ></textarea>
                        </div>
                    
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hien thi</label>
                            <select name="slider_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                              
                            </select>
                        </div>
                        <button type="submit" name="add_brand_product" class="btn btn-success">Thêm Slider</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection