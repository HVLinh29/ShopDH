@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Liệt kê đơn hàng
    </div>
    <div class="row w3-res-tb">
     
     
    
    </div>
    <div class="table-responsive">
                      <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
           
            <th style="color:brown">Thứ tự</th>
            <th style="color:brown">Mã đơn hàng</th>
            <th style="color:brown">Ngày tháng đặt hàng</th>
            <th style="color:brown">Tình trạng đơn hàng</th>
            <th style="color:brown">Lý do hủy</th>
            <th style="color:brown">Quản lý</th>

            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @php 
          $i = 0;
          @endphp
          @foreach($orderr as $key => $ord)
            @php 
            $i++;
            @endphp
          <tr>
            <td><i>{{$i}}</i></label></td>
            <td>{{ $ord->order_code }}</td>
            <td>{{ $ord->created_at }}</td>
            <td>@if($ord->order_status==1)
                    Đơn hàng mới
                @elseif($ord->order_status==2)
                Đã xử lý-Đã giao hàng
                @else
                Đơn hàng đã bị hủy
                @endif
            </td>
            <td>
              @if($ord->order_status==3)
              {{ $ord->order_destroy }}
              @endif
            </td>
           
            <td>
              <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="active styling-edit btn btn-success" ui-toggle-class="">
               Xem</a>
              <a onclick="return confirm('Bạn có chắc là muốn xóa đơn hàng này?')" href="{{URL::to('/delete-order/'.$ord->order_code)}}" 
                class="active styling-edit btn btn-danger" ui-toggle-class="">
                Xóa
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