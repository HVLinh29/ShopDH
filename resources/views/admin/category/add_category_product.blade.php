@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Thêm danh mục sản phẩm
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
                        <form role="form" action="{{URL::to('/save-category-product')}}" method="POST">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">Tên danh mục</label>
                                <input type="text"  class="form-control"  onkeyup="ChangeToSlug();" name="tendanhmuc"  id="slug"  >
                            </div>
                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" name="danhmuc_slug" class="form-control" id="convert_slug" placeholder="Tên danh mục">
                            </div>
                        <div class="form-group">
                            <label for="">Mô tả danh mục</label>
                            <textarea style="resize: none"rows="5"  name="danhmuc_desc" class="form-control" id="" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Từ khóa danh mục</label>
                            <textarea style="resize: none"rows="5"  name="danhmuc_keywords" class="form-control" id="" ></textarea>
                        </div>
                       
                        <div class="form-group">
                            <label for="">Hiển thị</label>
                            <select name="danhmuc_status" class="form-control input-sm m-bot15">
                                <option value="1">Ẩn</option>
                                <option value="0">Hiển thị</option>
                              
                            </select>
                        </div>
                        <button type="submit" name="add_danhmuc" class="btn btn-success">Thêm danh mục</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection