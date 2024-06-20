@extends('admin_layout')
@section('admin_content')
 
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <div class="table-responsive">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Liệt kê danh mục sản phẩm</h3>
            </div>

            <div class="panel-body">
                <a href="{{ URL::to('/add-category-product') }}" class="btn btn-primary mb-3">Thêm danh mục</a>
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr class="thead-dark">
                            <th scope="col">STT</th>
                            <th scope="col">Tên danh mục</th>
                            <th scope="col">Slug</th>
                          
                            <th scope="col">Hiển thị</th>
                            <th scope="col">Quản lý</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_category_product as $key => $cate_pro)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $cate_pro->tendanhmuc }}</td>
                                <td>{{ $cate_pro->danhmuc_slug }}</td>
                                
                                <td>
                                    @if($cate_pro->danhmuc_status==0)
                                        <a href="{{ URL::to('/unactive-category-product/' . $cate_pro->category_id) }}">
                                            <i class="fas fa-thumbs-up text-success"></i>
                                        </a>
                                    @else
                                        <a href="{{ URL::to('/active-category-product/' . $cate_pro->category_id) }}">
                                            <i class="fas fa-thumbs-down text-danger"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ URL::to('/edit-category-product/' . $cate_pro->category_id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <a onclick="return confirm('Bạn có muốn xóa danh mục này?')" href="{{ URL::to('/delete-category-product/' . $cate_pro->category_id) }}" class="btn btn-sm btn-danger">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
