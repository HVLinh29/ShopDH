@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật thương hiệu
                </header>
                <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                <div class="panel-body">
                    @foreach($edit_brand_product as $key =>$edit_value)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-brand-product/'.$edit_value->brand_id)}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">Tên thuong hieu</label>
                                <input type="text" value="{{$edit_value->tenthuonghieu}}"  onkeyup="ChangeToSlug();" name="tenthuonghieu" class="form-control" id="slug" >
                            </div>
                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" value="{{$edit_value->thuonghieu_slug}}" name="thuonghieu_slug" class="form-control" id="convert_slug" >
                            </div>
                        <div class="form-group">
                            <label for="">Mô tả thương hiệu</label>
                            <textarea style="resize: none"rows="5"  name="thuonghieu_desc" class="form-control" 
                             id="" >{{$edit_value->thuonghieu_desc}}</textarea>
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Hiển thị</label>
                            <select name="thuonghieu_status" class="form-control input-sm m-bot15">
                                <option value="1">Ẩn</option>
                                <option value="0">Hiển thị</option>
                              
                            </select>
                        </div> --}}
                    
                        <button type="submit" name="update_thuonghieu" class="btn btn-success">Cập nhật thương hiệu</button>
                    </form>
                    </div>
                    @endforeach

                </div>
            </section>

    </div>
    
</div>
@endsection