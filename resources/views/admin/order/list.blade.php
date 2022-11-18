@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('act_danger'))
                <div class="alert alert-danger">
                    {{ session('act_danger') }}
                </div>
            @endif
            @if (session('act_success'))
                <div class="alert alert-success">
                    {{ session('act_success') }}
                </div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="" class="d-flex" method="GET">
                        <input style="width: 214px;" type="text" name="keyword" value="" class="form-control form-search"
                            placeholder="Tìm kiếm mã | khách hàng">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.order.action') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ route('admin.order.list') }}" class="text-primary">Tất cả<span
                                class="text-muted">({{ $counts[0] }})</span></a>
                        <a href="{{ route('admin.order.list', ['status' => '1']) }}" class="text-primary">Đang xử lí<span
                                class="text-muted">({{ $counts[1] }})</span></a>
                        <a href="{{ route('admin.order.list', ['status' => '2']) }}" class="text-primary">Đang vận
                            chuyển<span class="text-muted">({{ $counts[2] }})</span></a>
                        <a href="{{ route('admin.order.list', ['status' => '3']) }}" class="text-primary">Hoàn thành<span
                                class="text-muted">({{ $counts[3] }})</span></a>
                        <a href="{{ route('admin.order.list', ['status' => '0']) }}" class="text-primary">Hủy đơn<span
                                class="text-muted">({{ $counts[4] }})</span></a>
                        <a href="{{ route('admin.order.list', ['status' => 'trash']) }}" class="text-primary">Thùng
                            rác<span class="text-muted">({{ $counts[5] }})</span></a>
                    </div>
                    <div class="form-action form-inline py-3">
                        <select name="act" class="form-control mr-1" id="">
                            <option value=" ">Chọn</option>
                            @foreach ($list_act as $key => $act)
                                <option value="{{ $key }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
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
                                        <td>{{ format_created_at($item->created_at)}}</td>
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
            </form>
        </div>
    </div>
@endsection
