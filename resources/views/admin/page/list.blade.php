@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
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
            @if (session('list_check'))
                <div class="alert alert-danger">
                    {{ session('list_check') }}
                </div>
            @endif
            @if (session('middle'))
                <script>
                    confirm('Bạn chưa được cấp quyền để vào trang');
                </script>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách trang</h5>
                <div class="form-search form-inline">
                    <form action="{{ route('admin.page.list') }}" class="d-flex" method="GET">
                        @csrf
                        <input type="text" name="keyword" value="" class="form-control form-search"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.page.action') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        {{-- <a href="{{ request()->fullUrlWithQuery(["status"=>'active']) }}" class="text-primary">Kích hoạt<span class="text-muted">(10)</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span class="text-muted">(20)</span></a> --}}
                        <a href="{{ route('admin.page.list', ['status' => 'active']) }}" class="text-primary">Tất cả<span
                                class="text-muted">({{ $counts[0] }})</span></a>
                        <a href="{{ route('admin.page.list', ['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                                class="text-muted">({{ $counts[1] }})</span></a>
                    </div>
                    <div class="form-action form-inline py-3">
                        <select name='act' class="form-control mr-1" id="">
                            <option value=" ">Chọn</option>
                            @foreach ($list_act as $key => $act)
                                <option value="{{ $key }}">{{ $act }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn_apply" value="Áp dụng" class="btn btn-primary">
                    </div>
                    
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$pages->isEmpty())
                                @php
                                    $stt = 0;
                                @endphp
                                {{-- {{ $pages->total() }} --}}
                                @foreach ($pages as $page)
                                    @php
                                        $stt++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="listcheck[]" value="{{ $page->id }}">
                                        </td>
                                        <td scope="row">{{ $stt }}</td>
                                        <td><a href="">{{ $page->title }}</a>
                                        <td><span
                                                class="badge badge-{{ $page->status == 0 ? 'warning' : 'success' }}">{{ format_status($page->status) }}</span>
                                        </td>
                                        <td>{{ $page->name }}</td>
                                        <td>{{ format_created_at($page->created_at) }}</td>
                                        <td>
                                            @if (request()->status == 'trash')
                                                <a href="{{ route('admin.page.restore', ['id' => $page->id]) }}"
                                                    class="btn btn-secondary btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa-solid fa-rotate-left"></i></a>
                                                <a onclick="return confirm('Bạn có muốn xóa trang này không?')"
                                                    href="{{ route('admin.page.forceDelete', ['id' => $page->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('admin.page.edit', ['id' => $page->id]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Bạn có muốn xóa trang này không?')"
                                                    href="{{ route('admin.page.delete', ['id' => $page->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif

                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="alert alert-danger" role="alert" colspan="7">Không tìm thấy trang
                                        nào
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    {{ $pages->links() }}
                </div>
            </form>
        </div>
    </div>
@endsection
