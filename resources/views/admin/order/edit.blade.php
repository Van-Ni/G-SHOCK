@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if (session('act_success'))
                        <div class="alert alert-success">
                            {{ session('act_success') }}
                        </div>
                    @endif
                    <div class="card-header font-weight-bold">
                        Thông tin đơn hàng
                    </div>
                    <div class="card-body ">
                        <h5 class="text-primary"><i class="far fa-address-card"></i> Thông tin khách hàng</h5>
                        <table class="table table-bordered mt-3 shadow-sm">
                            <tbody>
                                <tr class="bg-light">
                                    <th>Mã đơn</th>
                                    <th>Họ và tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>
                                    <th>Ghi chú</th>
                                    <th>Ngày đặt hàng</th>
                                </tr>
                                <tr>
                                    @foreach ($order as $item)
                                    <td>{{ $item->order_code }}</td>
                                        <td>{{ $item->customer_name }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ !empty($item->note) ? $item->note : "" }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        <div class="row mt-4">
                            <div class="col-5">
                                <h5 class="text-primary mb-3"><i class="fas fa-list-alt"></i> Trạng thái đơn hàng:
                                    @php
                                        $status = 'dark';
                                        if ($item->status == '1') {
                                            $status = 'danger';
                                        } elseif ($item->status == '2') {
                                            $status = 'success';
                                        } elseif ($item->status == '3') {
                                            $status = 'primary';
                                        }
                                        
                                    @endphp
                                    @foreach ($order as $item)
                                        <span
                                            class="badge badge-{{ $status }} py-1">{{ format_status_order($item->status) }}</span>
                                    @endforeach
                                </h5>
                                <form action="{{ route('admin.order.update', ['id' => request()->id]) }}" method="POST">
                                    @csrf
                                    <div class="form-inline">
                                        <select class="form-control mr-1" name="action" style="width:270px">
                                            @foreach ($order as $item)
                                                <option value="1" {{ $item->status == '1' ? 'selected' : '' }}>Đang xử
                                                    lí</option>
                                                <option value="2" {{ $item->status == '2' ? 'selected' : '' }}>Đang
                                                    vận chuyển</option>
                                                <option value="3" {{ $item->status == '3' ? 'selected' : '' }}>Hoàn
                                                    thành</option>
                                                <option value="0"{{ $item->status == '0' ? 'selected' : '' }}>Hủy đơn</option>
                                            @endforeach
                                        </select>
                                        <input type="submit" name="btn-search" value="Cập nhật" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <div class="col-7">
                                <table class="table table-bordered text-center shadow-sm">
                                    <tbody>
                                        <tr>
                                            <th>Tổng số lượng</th>
                                            <th>Tổng tiền</th>
                                        </tr>
                                        <tr>
                                            @foreach ($order as $item)
                                                <td>{{ $item->total_order }} Sản phẩm</td>
                                                <td>{{ currency_format($item->total_price) }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        Chi tiết đơn hàng
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Màu sản phẩm</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_product as $item)
                                    <tr>
                                        <td><img src="{{ asset("{$item['options']['thumb']}") }}" alt="" style="max-width:100px;height:auto;"></td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['options']['color'] !== 'NULL' ? $item['options']['color'] : "" }}</td>
                                        <td>{{ currency_format($item['price']) }}</td>
                                        <td>{{ $item['qty'] }}</td>
                                        <td>{{ currency_format($item['subtotal']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
