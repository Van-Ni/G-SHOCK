@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form id="upload-post" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Chọn tên module</label>
                        <select name="module_parent" id="" class="form-control">
                            @foreach (config('permissions.module_table') as $k => $item)
                                <option value="{{ $item }}">{{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="container">
                        <div class="row">
                            @foreach (config('permissions.module_children') as $k => $item)
                            <div class="col">
                                <input value="{{ $item }}" type="checkbox" name="module_children[]" id="">
                                <label for="">{{ $k }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
