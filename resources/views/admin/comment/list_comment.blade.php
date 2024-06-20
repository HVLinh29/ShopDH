@extends('admin_layout')
@section('admin_content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Comment
            </div>
            <div id="notify_comment"></div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <thead>
                        <tr>

                           
                            <th style="color: brown">Tên người gửi</th>
                            <th style="color: brown">Bình luận</th>
                            <th style="color: brown">Ngày gửi</th>
                            <th style="color: brown">Sản phẩm</th>
                            <th style="color: brown">Quản lý</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comment as $key => $comm)
                            <tr>
                                

                                <td>{{ $comm->cmt_name }}</td>
                                <td>{{ $comm->cmt }}
                                </td>
                                <td>{{ $comm->cmt_date }}</td>
                                <td><a href="{{ url('/chi-tiet-san-pham/' . $comm->product->product_slug) }}"
                                        target="_blank">{{ $comm->product->product_name }}</td>
                                <td>
                                    <a onclick="return confirm('Bạn có muốn xóa bình luận này?')" href="{{URL::to('/delete-comment/'.$comm->cmt_id)}}"
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
