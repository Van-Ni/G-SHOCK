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
                <h5 class="m-0 ">Danh sách thành viên</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="text" name="keyword" value="" class="form-control form-search"
                            placeholder="Tìm kiếm họ tên | Email">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    </form>
                </div>
            </div>
            <form action="{{ route('admin.user.action') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="analytic">
                        {{-- <a href="{{ request()->fullUrlWithQuery(["status"=>'active']) }}" class="text-primary">Kích hoạt<span class="text-muted">(10)</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span class="text-muted">(20)</span></a> --}}
                        <a href="{{ route('admin.user.list', ['status' => 'active']) }}" class="text-primary">Kích hoạt<span
                                class="text-muted">({{ $counts[0] }})</span></a>
                        <a href="{{ route('admin.user.list', ['status' => 'trash']) }}" class="text-primary">Vô hiệu
                            hóa<span class="text-muted">({{ $counts[1] }})</span></a>
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
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Email</th>
                                {{-- <th scope="col">Quyền</th> --}}
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$users->isEmpty())
                                @php
                                    $stt = 0;
                                @endphp
                                {{-- {{ $users->total() }} --}}
                                @foreach ($users as $user)
                                    @php
                                        $stt++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input name="listcheck[]" value="{{ $user->id }}" type="checkbox">
                                        </td>

                                        <th scope="row">{{ $stt }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        {{-- <td>{{ $user->role_name }}</td> --}}
                                        <td>{{ format_created_at($user->created_at) }}</td>
                                        <td>
                                            @if (request()->status == 'trash')
                                                <a href="{{ route('admin.user.restore', ['id' => $user->id]) }}"
                                                    class="btn btn-secondary btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa-solid fa-rotate-left"></i></a>
                                                <a onclick="return confirm('Bạn có muốn xóa thành viên này không?')"
                                                    href="{{ route('admin.user.forceDelete', ['id' => $user->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            @else
                                                <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                @if (Auth::id() != $user->id)
                                                    <a onclick="return confirm('Bạn có muốn xóa thành viên này không?')"
                                                        href="{{ route('admin.user.delete', ['id' => $user->id]) }}"
                                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i></a>
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="alert alert-danger" role="alert" colspan="7">Không tìm thấy thành viên
                                        nào
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </form>
        </div>
    </div>
@endsection
