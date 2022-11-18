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
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách bài viết</h5>
                <div class="form-search form-inline">
                    <form action="{{ route('admin.post.list') }}" class="d-flex" method="GET">
                        <input type="text" name="keyword" value="" class="form-control form-search"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.post.action') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        <a href="{{ route('admin.post.list') }}" class="text-primary">Tất cả<span
                                class="text-muted">({{ $counts[0] }})</span></a>
                        <a href="{{ route('admin.post.list', ['status' => '1']) }}" class="text-primary">Công khai<span
                                class="text-muted">({{ $counts[1] }})</span></a>
                        <a href="{{ route('admin.post.list', ['status' => '0']) }}" class="text-primary">Chờ duyệt<span
                                class="text-muted">({{ $counts[2] }})</span></a>
                        <a href="{{ route('admin.post.list', ['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                                class="text-muted">({{ $counts[3] }})</span></a>
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
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$posts->isEmpty())
                                @php
                                    $stt = $stt;
                                @endphp
                                {{-- {{ $posts->total() }} --}}
                                @foreach ($posts as $item)
                                    <tr>
                                        <td>
                                            <input value="{{ $item->id }}" name="listcheck[]" type="checkbox">
                                        </td>
                                        <td scope="row">{{ $stt }}</td>
                                        <td><a href=""><img class="thumb" src="{{ asset("{$item->thumb}") }}"
                                                    alt=""></a></td>
                                        <td><a
                                                href="{{ route('admin.post.edit', ['id' => $item->id]) }}">{{ Str::limit($item->title, 25) }}</a>
                                        </td>
                                        <td>{{ $item->cat_name }}</td>
                                        <td><span
                                                class="badge badge-{{ $item->status == 0 ? 'warning' : 'success' }}">{{ format_status($item->status) }}</span>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            @if (request()->status == 'trash')
                                                <a href="{{ route('admin.post.restore', ['id' => $item->id]) }}"
                                                    class="btn btn-secondary btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Restore"><i
                                                        class="fa-solid fa-rotate-left"></i></a>
                                                <a onclick="return confirm('Bạn có muốn xóa bài viết này không?')"
                                                    href="{{ route('admin.post.forceDelete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('admin.post.edit', ['id' => $item->id]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Bạn có muốn xóa bài viết này không?')"
                                                    href="{{ route('admin.post.delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif
                                        </td>

                                    </tr>
                                    @php
                                        $stt++;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td class="alert alert-danger" role="alert" colspan="9">Không tìm thấy bài viết
                                        nào
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    {{ $posts->links() }}
                </div>
            </form>
        </div>
    </div>
@endsection
