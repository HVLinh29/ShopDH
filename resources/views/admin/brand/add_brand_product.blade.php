@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                Thêm thương hiệu sản phẩm
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
                        <form role="form" action="{{URL::to('/save-brand-product')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">Tên thương hiệu</label>
                                <input type="text" name="tenthuonghieu" class="form-control" onkeyup="ChangeToSlug();" id="slug" >
                            </div>
                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" name="thuonghieu_slug" class="form-control" id="convert_slug" placeholder="Slug">
                            </div>
                        <div class="form-group">
                            <label for="">Mô tả thương hiệu</label>
                            <textarea style="resize: none"rows="5"  name="thuonghieu_desc" class="form-control" id="" ></textarea>
                        </div>
                    
                        <div class="form-group">
                            <label for="">Hiển thị</label>
                            <select name="thuonghieu_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                              
                            </select>
                        </div>
                        <button type="submit" name="add_thuonghieu" class="btn btn-success">Thêm thương hiệu</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection