@extends('layout')
@section('content_thu2')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê tất cả đơn hàng
            </div>
            <div class="row w3-res-tb">



            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th style="color:brown">Thứ tự</th>
                            <th style="color:brown">Mã đơn hàng</th>
                            
                            <th style="color:brown">Ngày tháng đặt hàng</th>
                            <th style="color:brown">Tình trạng đơn hàng</th>
                            <th style="color:brown">Quản lý</th>

                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($orderr as $key => $ord)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <td><i>{{ $i }}</i></label></td>
                                <td>{{ $ord->order_code }}</td>
                                <td>{{ $ord->created_at }}</td>
                                <td>
                                    @if ($ord->order_status == 1)
                                        Đơn hàng mới
                                    @elseif($ord->order_status == 2)
                                        Đã xử lý-Đã giao hàng
                                    @else
                                        Đơn hàng đã bị hủy
                                    @endif
                                </td>


                                <td>
                                    @if($ord->order_status !=3)
                                    <!-- Trigger the modal with a button -->
                                    <p><button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#huydonhang">Hủy đơn hàng</button></p>
                                    @endif
                                    <!-- Modal -->
                                    <div id="huydonhang" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <form>
                                                @csrf

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Lý do hủy đơn hàng</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            <textarea rows="5" class="lydohuy" required placeholder="Lý do hủy"></textarea>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="button" onclick="huydh(this.id)"
                                                            id="{{ $ord->order_code }}" class="btn btn-success">Gửi</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                    <p><a href="{{ URL::to('/lich-su-don-hang/' . $ord->order_code) }}"
                                            class="active styling-edit btn btn-success" ui-toggle-class="">
                                            Xem đơn hàng
                                        </a></p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
