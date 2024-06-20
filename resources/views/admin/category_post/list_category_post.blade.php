@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

<div class="table-agile-info">
    <div class="panel panel-default">
      <header class="panel-heading">
      Liệt kê danh mục bài viết
    </header>
      
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" id="myTable">
          <style>
            .custom-button {
                background-color: brown;
                color: white;
                padding: 10px 20px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 5px 2px;
                cursor: pointer;
                border: none;
                border-radius: 4px;
            }
        </style>
          <a href="{{ URL::to('/add-category-post') }}"  class="custom-button">Thêm danh mục bài viết</a>
          <?php
          $message = Session::get('message');
          if($message){
              echo '<span class="text-alert">'.$message.'</span>';
              Session::put('message',null);
          }
          ?>
          <thead>
            <tr>
              <th style="color:brown">Tên danh mục bài viết</th>
              <th style="color:brown">Slug</th>
              <th style="color:brown">Mô tả danh mục</th>
              <th style="color:brown">Hiển thị</th>
              <th style="color:brown">Quản lý</th>
            
            </tr>
          </thead>
          <tbody>
            @foreach($category_post as $key =>$article)
            <tr>
              <td>{{$article->article_name}}</td>
              <td>{{$article->article_slug}}</td>
              <td>{{$article->article_desc}}</td>
              <td>
                @if($article->article_status==0)
                <span style="color:red">Ẩn</span>
                @else
                <span style="color:green">Hiển thị</span>
                @endif
              </td>
              
              <td>
                <a href="{{URL::to('/edit-category-post/'.$article->article_id)}}" class="active btn btn-success" ui-toggle-class="">
                 Sửa</a>
                <a onclick="return confirm('Bạn có muốn xóa danh mục này?')" href="{{URL::to('/delete-category-post/'.$article->article_id)}}" 
                  class="active btn btn-danger" ui-toggle-class="">Xóa
                 </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      

      </div>
      
    </div>
  </div>
@endsection