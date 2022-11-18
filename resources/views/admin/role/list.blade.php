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
                <h5 class="m-0 ">Danh sách vai trò</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="text" name="keyword" value="" class="form-control form-search"
                            placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        <input type="hidden" name="status" value="{{ request()->status }}">
                    </form>
                </div>
            </div>
            <form action="" method="POST">
                @csrf
                <div class="card-body">
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col">Tên vai trò</th>
                                <th scope="col">Mô tả vai trò</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$roles->isEmpty())
                                @php
                                    $stt = 0;
                                @endphp
                                {{-- {{ $users->total() }} --}}
                                @foreach ($roles as $item)
                                    @php
                                        $stt++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input name="listcheck[]" value="{{ $item->id }}" type="checkbox">
                                        </td>

                                        <th scope="row">{{ $stt }}</th>
                                        <td>{{ $item->role_name }}</td>
                                        <td>{{ $item->display_name }}</td>
                                        {{-- <td>{{ $user->role_name }}</td> --}}
                                        <td>
                                            <a href="{{ route("admin.role.edit",['id'=>$item->id]) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                    class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Bạn có muốn xóa vai trò này không?')"
                                                href="{{ route("admin.role.delete",['id'=>$item->id]) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
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
                    {{-- {{ $users->links() }} --}}
                </div>
            </form>
        </div>
    </div>
@endsection
