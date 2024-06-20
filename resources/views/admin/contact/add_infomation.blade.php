@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                Thêm thông tin Website
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
                        @foreach($contact as $key =>$cont)
                        <form role="form" action="{{URL::to('/update-info/'.$cont->ct_id)}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thông tin liên hệ</label>
                            <textarea style="resize: none"rows="5" data-validation="length" data-validation-length="min10" 
                            data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự"  name="ct_contact" class="form-control" id="cheditor" >
                            {{$cont->ct_contact}}
                        </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Bản đồ</label>
                            <textarea style="resize: none"rows="5" data-validation="length" data-validation-length="min10" 
                            data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự"  name="ct_map" class="form-control" id="" >
                            {{$cont->ct_map}}
                        </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Fanpage</label>
                            <textarea style="resize: none"rows="5" data-validation="length" data-validation-length="min10" 
                            data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự"  name="ct_fanpage" class="form-control" id="" >
                            {{$cont->ct_fanpage}}
                        </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh</label>
                            <input type="file" class="form-control"  name="ct_image"  id="">
                            <img src="{{ asset('public/uploads/contact/' . $cont->ct_logo) }}" width="100" height="100">

                        </div>
                    
                    
                        <button type="submit" name="add_info" class="btn btn-success">Cập nhật thông tin</button>
                    </form>
                    @endforeach
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection