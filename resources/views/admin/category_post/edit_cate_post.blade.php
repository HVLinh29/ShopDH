@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Cap nhat danh mục bai viet
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
                        <form role="form" action="{{URL::to('/update-category-post/'.$category_post->article_id)}}" method="POST">
                            {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Tên danh mục</label>
                            <input type="text" class="form-control" value="{{$category_post->article_name}}"  name="article_name"  id="slug" onkeyup="ChangeToSlug();" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" name="article_slug" value="{{$category_post->article_slug}}" class="form-control" id="convert_slug" placeholder="Slug">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize: none"rows="5"  name="article_desc" class="form-control" id="" >{{$category_post->article_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="article_status" class="form-control input-sm m-bot15">
                                @if($category_post->article_status==0)
                                <option selected value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                                @else
                                <option  value="0">Ẩn</option>
                                <option selected value="1">Hiển thị</option>
                              @endif
                            </select>
                        </div>
                        <button type="submit" name="update_article" class="btn btn-success">Cập nhật danh mục bài viết</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection