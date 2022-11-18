@extends('layouts.admin')
@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $counts[0] }}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $counts[1] }}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    @foreach ($ourSale as $item)
                    <h5 class="card-title">{{ currency_format($item->total_sale) }}</h5>
                    @endforeach
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $counts[2] }}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input value="" type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if (!$orders->isEmpty())
                        @php
                            $stt = 0;
                        @endphp
                        {{-- {{ $orders->total() }} --}}
                        @foreach ($orders as $item)
                            @php
                                $stt++;
                            @endphp
                            <tr>
                                <td>
                                    <input value="{{ $item->id }}" name="listcheck[]" type="checkbox">
                                </td>
                                <td>{{ $stt }}</td>
                                <td><a href="{{ route('admin.order.edit', ['id' => $item->id]) }}">{{ $item->order_code }}</a></td>
                                <td>
                                    {{ $item->customer_name }} <br>
                                    {{ $item->phone_number }}
                                </td>
                                <td>{{ $item->total_order }}</td>
                                <td>{{ currency_format($item->total_price) }}</td>
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
                                <td><span
                                        class="badge badge-{{ $status }}">{{ format_status_order($item->status) }}</span>
                                </td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    @if (request()->status == 'trash')
                                        <a href="{{ route('admin.order.restore', ['id' => $item->id]) }}"
                                            class="btn btn-secondary btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Restore"><i
                                                class="fa-solid fa-rotate-left"></i></a>
                                        <a onclick="return confirm('Bạn có muốn đơn hàng này không?')"
                                            href="{{ route('admin.order.forceDelete', ['id' => $item->id]) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    @else
                                        <a href="{{ route('admin.order.edit', ['id' => $item->id]) }}"
                                            class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Bạn có muốn đơn hàng này không?')"
                                            href="{{ route('admin.order.delete', ['id' => $item->id]) }}"
                                            class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="alert alert-danger" role="alert" colspan="11">Không tìm thấy đơn hàng
                                nào
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection