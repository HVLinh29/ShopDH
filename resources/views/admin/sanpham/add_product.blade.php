@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                  Thêm sản phẩm
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
                        <form role="form" action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" data-validation="length" data-validation-length="min10" 
                                data-validation-error-msg="Làm ơn điền ít nhất 10 ký tự" name="product_name" class="form-control " 
                                id="slug" onkeyup="ChangeToSlug();"> 
                            </div>
                            <div class="form-group">
                                <label for="">Slug</label>
                                <input type="text" name="product_slug" class="form-control " id="convert_slug" >
                            </div>
                        <div class="form-group">
                            <label for="">Số lượng sản phẩm</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số lượng" name="product_quantity" 
                            class="form-control" id="" >
                        </div>
                        <div class="form-group">
                            <label for="">Hình ảnh sản phẩm</label>
                            <input type="file" class="form-control"  name="product_image"  id="">
                        </div>
                        
                        <div class="form-group">
                            <label for="">Mô tả sản phẩm</label>
                            <textarea style="resize: none"rows="5"  name="product_desc" id="cheditor" class="form-control" id="cheditor" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Nội dung sản phẩm</label>
                            <textarea style="resize: none"rows="5"  name="product_content" id="cheditor1" class="form-control" id="cheditor1"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Gía chưa khuyến mãi</label>
                            <input type="text" class="form-control money"  name="product_km"  id="" >
                        </div>
                        <div class="form-group">
                            <label for="">Gía sản phẩm</label>
                            <input type="text" class="form-control money"  name="product_price"  id="" >
                        </div>
                       
                        <div class="form-group">
                            <label for="">Gía gốc</label>
                            <input type="text" class="form-control money_cost" name="product_cost"  id="" >
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key =>$cate)
                                <option value="{{$cate->category_id}}">{{$cate->tendanhmuc}}</option>
                                @endforeach
                              
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Thương hiệu</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key =>$brand)
                                <option value="{{$brand->brand_id}}">{{$brand->tenthuonghieu}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tags san pham</label>
                            <input type="text" data-role="tagsinput" class="form-control"  name="product_tags"  id="">
                        </div>
                        <div class="form-group">
                            <label for="">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="1">Ẩn</option>
                                <option value="0">Hiển thị</option>
                              
                            </select>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-success">Thêm sản phẩm</button>
                    </form>
                    </div>

                </div>
            </section>

    </div>
    
</div>
@endsection