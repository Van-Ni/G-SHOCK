@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('danger'))
                    <div class="alert alert-danger">
                        {{ session('danger') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Màu sản phẩm
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('admin.product.storeColor') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên màu</label>
                                <input class="form-control" type="text" name="name" id="name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="color">Chọn màu</label>
                                <input class="form-control" type="color" name="color" value="#000" id="color">
                                @error('color')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên màu</th>
                                    <th scope="col">Khối màu</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$colors->isEmpty())
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($colors as $item)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $stt }}</th>
                                            <td scope="row">{{ $item->color_name }}</td>
                                            <td scope="row">
                                                <div style="background-color:{{ $item->color_order }};padding: 5px"></div>
                                            </td>
                                            <td scope="row">{{ $item->name }}</td>
                                            <td>
                                                <a onclick="return confirm('Bạn có muốn xóa màu này không?')"
                                                    href="{{ route('admin.product.colorDelete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $colors->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
