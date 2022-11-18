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
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="" class="d-flex" method="GET">
                        <input type="text" name="keyword" value="" class="form-control form-search"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.product.action') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ route('admin.product.list') }}" class="text-primary">Tất cả<span
                                class="text-muted">({{ $counts[0] }})</span></a>
                        <a href="{{ route('admin.product.list', ['status' => '1']) }}" class="text-primary">Còn hàng<span
                                class="text-muted">({{ $counts[1] }})</span></a>
                        <a href="{{ route('admin.product.list', ['status' => '0']) }}" class="text-primary">Hết hàng<span
                                class="text-muted">({{ $counts[2] }})</span></a>
                        <a href="{{ route('admin.product.list', ['status' => 'trash']) }}" class="text-primary">Thùng
                            rác<span class="text-muted">({{ $counts[3] }})</span></a>
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
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên sản phẩm</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Danh mục</th>
                                {{-- <th scope="col">Thương hiệu</th> --}}
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$products->isEmpty())
                                @php
                                    $stt = $stt++;
                                @endphp
                                {{-- {{ $products->total() }} --}}
                                @foreach ($products as $item)
                                    <tr class="">

                                        <td>
                                            <input name="listcheck[]" value="{{ $item->id }}"type="checkbox">
                                        </td>
                                        <td>{{ $stt }}</td>
                                        <td><a href="{{ route('admin.product.edit', ['id' => $item->id]) }}">
                                                <img style="width:100px"class="thumb"src="{{ asset("{$item->product_thumb}") }}"
                                                    alt=""></a>
                                        </td>
                                        <td><a
                                                href="{{ route('admin.product.edit', ['id' => $item->id]) }}">{{ Str::limit("{$item->product_name}", 20) }}</a>
                                        </td>
                                        <td>{{ currency_format($item->price) }}</td>
                                        <td>{{ $item->cat_name }}</td>
                                        {{-- <td>{{ $item->trademark_name }}</td> --}}
                                        <td>{{ $item->name }}</td>
                                        <td>{{ format_created_at($item->created_at) }}</td>
                                        <td><span
                                                class="badge badge-{{ $item->status == 0 ? 'warning' : 'success' }}">{{ format_status_product($item->status) }}</span>
                                        </td>
                                        <td class="d-flex">

                                            @if (request()->status == 'trash')
                                                <a href="{{ route('admin.product.restore', ['id' => $item->id]) }}"
                                                    class="btn btn-secondary btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Restore"><i
                                                        class="fa-solid fa-rotate-left"></i></a>
                                                <a onclick="return confirm('Bạn có muốn sản phẩm viết này không?')"
                                                    href="{{ route('admin.product.forceDelete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                @can('update_product', $item->id)
                                                    <a href="{{ route('admin.product.edit', ['id' => $item->id]) }}"
                                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('delete_product')
                                                    <a onclick="return confirm('Bạn có muốn sản phẩm viết này không?')"
                                                        href="{{ route('admin.product.delete', ['id' => $item->id]) }}"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i></a>
                                                @endcan
                                                <a href="{{ route('admin.product.moreImage', ['id' => $item->id]) }}"
                                                    class="btn btn-info btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Thêm hình ảnh"><i
                                                        class="fa-solid fa-upload"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $stt++;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td class="alert alert-danger" role="alert" colspan="11">Không tìm thấy sản phẩm
                                        nào
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{-- {{ $products->links() }} --}}
                    {{ $products->links('product.paginate') }}
                </div>
            </form>
        </div>
    </div>
@endsection
