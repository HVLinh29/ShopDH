<td>
    <a style="color: green; font-size:18px">Tổng tiền :<span>{{ number_format($total, 0, ',', '.') }} VNĐ</span>
    </a>
    @if (Session::get('coupon'))
        <a>
            <a style="color: red;font-sixe:16px">
            @foreach (Session::get('coupon') as $key => $cou)
                @if ($cou['coupon_condition'] == 1)
                    Mã giảm : {{ $cou['coupon_number'] }} %
                    <p>
                        @php
                            $total_coupon =
                                ($total * $cou['coupon_number']) / 100;
                        @endphp
                    </p>
                    <p>
                        @php
                            $total_after_coupon =
                                $total - $total_coupon;
                        @endphp
                    </p>
                @elseif($cou['coupon_condition'] == 2)
                    Mã giảm :
                    {{ number_format($cou['coupon_number'], 0, ',', '.') }}
                    VNĐ
                    <p>
                        @php
                            $total_coupon =
                                $total - $cou['coupon_number'];

                        @endphp
                    </p>
                    @php
                        $total_after_coupon = $total_coupon;
                    @endphp
                @endif
            @endforeach
                </a>
    @endif

    @if (Session::get('fee'))
       
        </br>
            <a style="color: RED; font-size:18px" class="cart_quantity_delete"
                href="{{ url('/del-fee') }}"><i
                    class="fa fa-times"></i></a>
            Phí vận chuyển
            <span>{{ number_format(Session::get('fee'), 0, ',', '.') }}đ</span>
        </a>
        <?php $total_after_fee = $total + Session::get('fee'); ?>
    @endif
    </br>
    <a style="color: red;font-size:18px">Tổng còn:
        @php
            if (Session::get('fee') && !Session::get('coupon')) {
                $total_after = $total_after_fee;
                echo number_format($total_after, 0, ',', '.') . ' VNĐ';
            } elseif (!Session::get('fee') && Session::get('coupon')) {
                $total_after = $total_after_coupon;
                echo number_format($total_after, 0, ',', '.') . ' VNĐ';
            } elseif (Session::get('fee') && Session::get('coupon')) {
                $total_after = $total_after_coupon;
                $total_after = $total_after + Session::get('fee');
                echo number_format($total_after, 0, ',', '.') . ' VNĐ';
            } elseif (!Session::get('fee') && !Session::get('coupon')) {
                $total_after = $total;
                echo number_format($total_after, 0, ',', '.') . ' VNĐ';
            }

        @endphp

        </a>
    <div class="col-md-12">
        @php

            $vnd_to_usd = $total_after / 25451;
            $total_paypal = round($vnd_to_usd, 2);
            \Session::put('total_paypal', $total_paypal);
        @endphp


    </div>


</td>