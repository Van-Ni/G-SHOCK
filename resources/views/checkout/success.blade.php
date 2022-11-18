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
                        <a href="" title="">Thông tin đặt hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content-cart')
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-order">
            <div class="order-success">
                <h1><i class="fa-solid fa-circle-check"></i>Đặt hàng thành công</h1>
                <p>Cảm ơn <strong>{{ !empty(Cookie::get('fullname')) ? Cookie::get('fullname') : '' }}</strong> đã cho chúng
                    tôi cơ hội được phục vụ!</p>
                <p>Nhân viên sẽ liên hệ lại quý khách để xác nhận giao hàng chậm nhất 24h.</p>
            </div>
            <div class="section-detail table-responsive">
                <h4>Mã đơn hàng: {{ request()->orderCode }}</h4>
                <table class="table table-bordered table-hover">
                    <caption>Thông tin khách hàng</caption>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{{ !empty(Cookie::get('fullname')) ? Cookie::get('fullname') : '' }}</th>
                            <td>{{ !empty(Cookie::get('phone')) ? Cookie::get('phone') : '' }}</td>
                            <td>{{ !empty(Cookie::get('email')) ? Cookie::get('email') : '' }}</td>
                            <td>{{ !empty(Cookie::get('fullAddress')) ? Cookie::get('fullAddress') : '' }}</td>
                            <td>{{ !empty(Cookie::get('note')) ? Cookie::get('note') : '' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="section-detail table-responsive">
                <table class="table table-bordered table-hover">
                    <caption>Sản phẩm đã mua</caption>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh sản phẩm</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Màu</th>
                            <th scope="col">Giá sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $stt = 0;
                        @endphp
                        @foreach ($list_product as $item)
                            @php
                                $stt = ++$stt;
                            @endphp
                            <tr>
                                <th>{{ $stt }}</th>
                                 <td><img style="width:100px" src="{{ asset("{$item["options"]["thumb"]}") }}" alt=""></td>
                                 <td>{{ $item['name'] }}</td>
                                <td>{{ $item['options']['color'] !== 'NULL' ? $item['options']['color'] : ""}}</td>
                                <td>{{ currency_format($item['price']) }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ currency_format($item['subtotal']) }}</td>  
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="thead-light">
                        <tr>
                            <th class="text-center" colspan="6">Tổng tiền:</th>
                            @foreach ($orders as $item)
                            <th>{{ currency_format($item->total_price) }}</th>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="order-contact">
            <p>Trước khi giao nhân viên sẽ gọi quý khách để xác nhận.</p>
            <p>Khi cần trợ giúp vui lòng gọi cho chúng tôi vào hotline: <a href="tel:+0902829118">0902.829.118</a></p>
            <a class="back-home" href="{{ route('home') }}">Quay lại cửa hàng</a>
        </div>
    </div>
@endsection
