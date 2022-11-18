@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm người dùng
            </div>

            <div class="card-body">
                <form action="{{ url('admin/user/store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Họ và tên</label>
                        <input class="form-control" type="text" name="name" id="name">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" type="text" name="email" id="email">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Mật khẩu</label>
                        <input class="form-control" type="password" name="password" id="password">
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Xác nhận mật khẩu</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password-confirm">
                    </div>
                    <div class="form-group">
                        <label for="">Nhóm quyền</label>
                        <select name="role[]"
                            class="form-control js-example-placeholder-multiple js-example-basic-multiple"
                            multiple="multiple">
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->role_name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" name="btn-add">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
            $(".js-example-placeholder-multiple").select2({
                placeholder: "Chọn vai trò"
            });
        });
    </script>
@endsection
