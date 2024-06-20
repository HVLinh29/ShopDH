@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật bài viết
                </header>
                <div class="panel-body">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('/update-post/'.$baivietbv->id_baiviet) }}" method="POST" enctype="multipart/form-data">                           @csrf
                            <div class="form-group">
                                <label for="">Tên bài viết</label>
                                <input type="text" class="form-control" value="{{$baivietbv->baiviet_title}}" name="baiviet_title"  id="slug" onkeyup="ChangeToSlug();" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" name="baiviet_slug" value="{{$baivietbv->baiviet_slug}}" class="form-control" id="convert_slug" placeholder="Slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tóm tắt bài viết</label>
                                <textarea style="resize: none"rows="5"  name="baiviet_desc" class="form-control" id="cheditor" >{{$baivietbv->baiviet_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung bài viết</label>
                                <textarea style="resize: none"rows="5"  name="baiviet_content" class="form-control" id="cheditor1" >{{$baivietbv->baiviet_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta từ khóa</label>
                                <textarea style="resize: none"rows="5"  name="baiviet_meta_keywords" class="form-control" id="" >{{$baivietbv->baiviet_meta_keywords}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta nội dung</label>
                                <textarea style="resize: none"rows="5"  name="baiviet_meta_desc" class="form-control" id="">{{$baivietbv->baiviet_meta_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                <input type="file" class="form-control"  name="baiviet_image"  id="exampleInputEmail1">
                                <img src="{{URL::to('public/uploads/post/'.$baivietbv->baiviet_image)}}" width="100" height="100">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục bài viết</label>
                                <select name="article_id" class="form-control input-sm m-bot15">
                                 @foreach($cate_post as $key =>$cate)
                                    <option {{$baivietbv->article_id==$cate->article_id ? 'selected' : ''}} 
                                        value="{{$cate->article_id}}">{{$cate->article_name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select name="baiviet_status" class="form-control input-sm m-bot15">
                                    @if($baivietbv->baiviet_status == 0)
                                    <option selected value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                    @else
                                    <option  value="0">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                    @endif

                                </select>
                            </div>
                            <button type="submit" name="update_baiviet  " class="btn btn-success">Cập nhật bài viết</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
