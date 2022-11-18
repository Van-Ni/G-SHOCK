@extends('layouts.main')
@section('section-cart')
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thông tin giỏ hàng của bạn</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content-cart')
    @if (!Cart::content()->isEmpty())
        <div id="wrapper" class="wp-inner clearfix">
            <form method="POST" id="form-post" class="form-inline" action="{{ route("checkCoupon") }}">
                @csrf
                <div class="input-group mb-2 mr-sm-2">
                    <label for="coupon-code"class="mr-2">Mã giảm giá</label>
                    <input name="coupon_code"
                     type="text" class="form-control"
                      id="coupon-code" placeholder="Nhập mã voucher tại đây">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </form>
            @if (!empty(session("info_sale")))
            @php
                $info_sale = session("info_sale");
            @endphp
            <ul>
                <li>Tổng tiền: {{ currency_format($info_sale['total']) }}</li>
                <li>Mã giảm: {{ $info_sale['coupon_number'] }}%</li>
                <li>Tổng giảm: {{ currency_format($info_sale['total_coupon_number']) }}</li>
                <li>Tổng giảm: {{ currency_format($info_sale['total_discount']) }}</li>
            </ul>
            @endif
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Ảnh sản phẩm</td>
                                <td>Tên sản phẩm</td>
                                <td>Màu</td>
                                <td>Giá sản phẩm</td>
                                <td>Số lượng</td>
                                <td>Thành tiền</td>
                                <td>Tác vụ</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                                <tr class="cartpage">
                                    <td>
                                        <a href="{{ action('ProductController@detailProduct', ['product' => $item->options->slug, 'id' => $item->id]) }}"
                                            title="" class="thumb">
                                            <img src="{{ asset("{$item->options->thumb}") }}" alt="">
                                        </a>
                                    </td>
                                    {{-- bs --}}
                                    <td class="text-left">
                                        <a href="{{ action('ProductController@detailProduct', ['product' => $item->options->slug, 'id' => $item->id]) }}"
                                            title="" class="name-product">{{ $item->name }}</a>
                                    </td>
                                    <td>{{ $item->options->color != 'NULL' ? $item->options->color : '' }}</td>
                                    <td>{{ currency_format($item->price) }}</td>
                                    <td>
                                        <div id="num-order-container">
                                            <a title=""class='minus-cart changeQuantity' id="minus-cart"><i
                                                    class="fa fa-minus"></i></a>
                                            <input type="number" name="num_order_cart" min="1"
                                                data-id="{{ $item->rowId }}" value="{{ $item->qty }}"
                                                class="num-order-cart" id="num-order-cart">
                                            <a title="" class='plus-cart changeQuantity' id="plus-cart"><i
                                                    class="fa fa-plus"></i></a>
                                        </div>
                                    </td>
                                    <td id="sub-total-{{ $item->rowId }}">{{ currency_format($item->subtotal) }}</td>
                                    <td>
                                        <a href="{{ route('deleteCart', ['id' => $item->rowId]) }}"
                                            data-id="{{ $item->rowId }}" title="Xóa sản phẩm" class="del-product"><i
                                                class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <p id="total-price" class="fl-right">Tổng giá:
                                            <span>{{ Cart::total() . '₫' }}</span>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <a href="{{ route('checkout') }}" title="" id="checkout-cart">Thanh
                                                toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="section" id="action-cart-wp">
                <div class="section-detail">
                    <p class="title"> Nhấn vào <strong>thanh toán</strong> để hoàn tất mua hàng.</p>
                    <div class="continue-shopping d-flex aligns-item-center">
                        <a href="{{ route('product') }}" title=""><i class="fa-solid fa-arrow-left-long"></i>Tiếp tục
                            mua sản
                            phẩm</a><br>
                        <a href="{{ route('destroyCart') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="cart-empty">
            <p>Chưa có sản phẩm nào trong giỏ hàng.</p>
            <a href="{{ route('home') }}">Quay trở lại cửa hàng</a>
        </div>
    @endif

    <script>
        $(document).ready(function() {
            $(".plus-cart").click(function() {
                let input = $(this).prev();
                let num = +($(this).prev().val());
                if (num >= 1) {
                    num++;
                }
                input.val(num);
            })
            $(".minus-cart").click(function() {
                let input = $(this).next();
                let num = +$(this).next().val();
                if (num > 1) {
                    num--;
                }
                input.val(num);
            })
            $(".changeQuantity").click(function() {
                var quantity = $(this).closest(".cartpage").find('.num-order-cart').val();
                console.log(quantity);
                var rowId = $(this).closest(".cartpage").find('.num-order-cart').attr('data-id');

                let data = {
                    quantity: quantity,
                    rowId: rowId,
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('updateCart') }}",
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                        $(`#sub-total-${rowId}`).text(data.subtotal);
                        $('#total-price span').text(data.total);
                        $("#total_order").text(data.total_qty);
                        $(`.qty-${rowId} span`).text(data.qty);
                        $(".total-price p.price").text(data.total);
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status);
                        alert(throwError);
                    },
                });
            });

            // delete cart : ajax
            $('.del-product').click(function(e) {
                e.preventDefault();
                let rowId = $(this).attr("data-id");
                let data = {
                    rowId: rowId
                };
                $(this).parent().parent().remove();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('deleteCart') }}",
                    method: "POST",
                    data: data,
                    dataType: "text",
                    success: function(data) {
                        console.log(data);
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status);
                        alert(throwError);
                    },
                });
            })
        })
    </script>
@endsection
