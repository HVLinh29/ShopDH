@extends('admin_layout')
@section('admin_content')
    <div class="container-fluid">
        <style type="text/css">
            p.title_thongke {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
            }
        </style>
    </div>
    <div class="row">
        <p class="title_thongke">THỐNG KÊ</p>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2">
                <p>Từ ngày: <input type="text" id="datepicker" class="form-control"></p></br>
                <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quá"></p>
            </div>
            <div class="col-md-2">
                <p>Đến ngày: <input type="text" id="datepicker2" class="form-control"></p>
            </div>
            <div class="col-md-2">
                <p>
                    Lọc theo
                    <select class="dashboard-filter form-control">
                        <option>Chọn</option>
                        <option value="7ngay">7 ngày qua</option>
                        <option value="thangtruoc">Tháng truóc</option>
                        <option value="thangnay">Thāng này</option>
                        <option value="365ngayqua">365 ngày qua</option>
                    </select>
                </p>
                <script type="text/javascript">
                    $(document).ready(function() {

                        chart60daysorder();

                        var chart = new Morris.Line({// thiet lap bieu do moris
                            element: 'chart',
                            lineColors: [
                                '#1ABC9C', // Màu xanh ngọc
                                '#E74C3C', // Màu đỏ tươi
                                '#3498DB', // Màu xanh dương sáng
                                '#9B59B6' // Màu tím sáng
                            ],

                            parseTime: false,
                            hideHover: 'auto',
                            xkey: 'period',
                            ykeys: ['order', 'sales', 'profit', 'quantity'],
                            labels: ['Đơn hàng', 'Doanh số',
                                'Lợi nhuận', 'Số lượng'
                            ]
                        });

                        function chart60daysorder() {
                            var _token = $('input[name="_token"]').val();
                            $.ajax({
                                url: '{{ url('/days-order') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    _token: _token

                                },
                                success: function(data) {
                                    chart.setData(data);
                                }
                            });
                        }

                        $('.dashboard-filter').change(function() {// lang nghe nhung thay doi
                            var dashboard_value = $(this).val();
                            var _token = $('input[name="_token"]').val();

                            $.ajax({
                                url: '{{ url('/dashboard-filter') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    _token: _token,
                                    dashboard_value: dashboard_value

                                },
                                success: function(data) {
                                    chart.setData(data);
                                }
                            });
                        });

                        $('#btn-dashboard-filter').click(function() {//loc tu ngay den ngay qua form date
                            var _token = $('input[name="_token"]').val();
                            var from_date = $('#datepicker').val();
                            var to_date = $('#datepicker2').val();

                            $.ajax({
                                url: '{{ url('/filter-by-date') }}',
                                method: 'POST',
                                dataType: 'JSON',
                                data: {
                                    _token: _token,
                                    from_date: from_date,
                                    to_date: to_date
                                },
                                success: function(data) {
                                    chart.setData(data);
                                }
                            });
                        });
                    });
                </script>


            </div>
        </form>
        <div class="col-md-12">
            <div id="chart" style="height:250px;"></div>
        </div>
    </div>
    
    </br>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <p class="title_thongke">Thống kê Tổng </p>
            <div id="donut" class="morris-donut-inverse"></div>
        </div>
        <div class="col-md-4 col-xs-12">
            <style>
                ul.list_views {
                    margin: 10px 0;
                    color: #fff;
                }

                ul.list_views a {
                    color: orange;
                    font-weight: 400;
                }
            </style>
            
        </div>
        <div class="col-md-4 col-xs-12">
            <p>
                <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                <span>Số lượng đơn hàng: {{ $order }}</span>
            </p>
            <p>
                <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                <span>Số lượng khách hàng: {{ $customer }}</span>
            </p>
            <p>
                <i class="fa fa-money fa-2x" aria-hidden="true"></i>
                <span>Doanh thu hôm nay: {{ number_format($doanhthu_homnay, 0, ',', '.') }} VNĐ</span>
            </p>
            <p>
                <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
                <span>Doanh thu tuần này: {{ number_format($doanhthu_tuan, 0, ',', '.') }} VND</span>
            </p>
            <p>
                <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
                <span>Doanh thu tháng này: {{ number_format($doanhthu_thang, 0, ',', '.') }} VNĐ</span>
            </p>
            <p>
                <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
                <span>Doanh thu tháng trước: {{ number_format($thangtruoc, 0, ',', '.') }} VNĐ</span>
            </p>
            <p>
                <i class="fa fa-calendar fa-2x" aria-hidden="true"></i>
                <span>Doanh thu năm nay: {{ number_format($doanhthu_nam, 0, ',', '.') }} VNĐ</span>
            </p>

        </div>
    </div>
@endsection
