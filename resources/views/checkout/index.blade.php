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
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('content-cart')
    <form method="POST" action="{{ route('storeCheckout') }}" name="form-checkout">
        @csrf
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">

                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên <span class="text-danger">(*)</span></label>
                            <input type="text" name="fullname" id="fullname"
                                value="{{ !empty(Cookie::get('fullname')) ? Cookie::get('fullname') : '' }}">
                            @error('fullname')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại <span class="text-danger">(*)</span></label>
                            <input type="tel" name="phone" id="phone"
                                value="{{ !empty(Cookie::get('phone')) ? Cookie::get('phone') : '' }}">
                            @error('phone')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-full d-flex flex-column">
                            <label for="email">Địa chỉ email</label>
                            <input type="email" name="email" id="email" placeholder="Email không bắt buộc"
                                value="{{ !empty(Cookie::get('email')) ? Cookie::get('email') : '' }}">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="province">Tỉnh / Thành phố <span class="text-danger">(*)</span></label>
                            <select name="province" class="form-control" id="province">
                                <option value="">Chọn tỉnh / thành phố</option>
                                @foreach ($provinces as $item)
                                    @if (Cookie::get('province') === $item->name)
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                    <option {{ $selected }} data-id="{{ $item->matp }}" value="{{ $item->name }}">{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="district">Quận / Huyện <span class="text-danger">(*)</span></label>
                            <select name="district" class="form-control" id="district">
                                <option value="">Chọn quận / huyện</option>
                                @if (!empty($districts))
                                    @foreach ($districts as $item)
                                    @if (Cookie::get('district') === $item->name)
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                     <option {{ $selected }} data-id="{{ $item->maqh }}" value='{{ $item->name }}' {}>{{$item->name}}</option>;
                                    @endforeach
                                @endif
                            </select>
                            @error('district')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Địa chỉ <span class="text-danger">(*)</span></label>
                            <input placeholder="Sô nhà, tên đường" type="text" name="address" id="address"
                            value="{{ !empty(Cookie::get('address')) ? Cookie::get('address') : '' }}"
                            >
                            @error('address')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="ward">Phường / Xã <span class="text-danger">(*)</span></label>
                            <select name="ward" class="form-control" id="ward">
                                <option value="">Chọn phường / xã</option>
                                @if (!empty($districts))
                                    @foreach ($wards as $item)
                                    @if (Cookie::get('ward') === $item->name)
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                     <option {{ $selected }} value='{{ $item->name }}' {}>{{$item->name}}</option>;
                                    @endforeach
                                @endif
                            </select>
                            @error('ward')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col d-flex flex-column">
                            <label for="notes">Ghi chú</label>
                            <textarea name="note" rows="5" placeholder="Ghi chú đơn hàng"></textarea>
                        </div>
                    </div>

                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                                <tr class="cart-item">
                                    <td class="product-name">{{ $item->name }}<strong
                                            class="product-quantity">{{ $item->options->color != 'NULL' ? '(' . $item->options->color . ')' : '' }}
                                            x {{ $item->qty }}</strong>
                                    </td>
                                    <td class="product-total">{{ currency_format($item->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price">{{ Cart::total() . '₫' }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <ul id="payment_methods">
                            <li>
                                <input type="radio" checked id="payment-home" name="payment-method"
                                    value="payment-home">
                                <label for="payment-home">Thanh toán tại nhà</label>
                            </li>
                        </ul>
                    </div>
                    <div class="place-order-wp clearfix">
                        <input type="submit" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("select#province").change(function() {
                var province = $(this).children("option:selected").val();
                var id = $(this).children("option:selected").attr("data-id");
                let data = {
                    province: province,
                    id: id
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('getDistrict') }}",
                    method: "POST",
                    data: data,
                    dataType: "text",
                    success: function(data) {
                        $("#district").html(data);
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status);
                        alert(throwError);
                    },
                });
            });
            $("select#district").change(function() {
                var district = $(this).children("option:selected").val();
                var id = $(this).children("option:selected").attr("data-id");
                let data = {
                    district: district,
                    id: id
                };
                console.log(data);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('getWard') }}",
                    method: "POST",
                    data: data,
                    dataType: "text",
                    success: function(data) {
                        $("#ward").html(data);
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status);
                        alert(throwError);
                    },
                });
            });
        });
    </script>
@endsection
