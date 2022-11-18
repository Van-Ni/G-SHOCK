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
                        Tên thương hiệu
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.storeTrademark') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên thương hiệu</label>
                                <input class="form-control" type="text" name="name" id="name">
                                @error('name')
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
                                    <th scope="col">Tên thương hiệu</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$trademarks->isEmpty())
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($trademarks as $item)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $stt }}</th>
                                            <td scope="row">{{ $item->trademark_name }}</td>
                                            <td scope="row">{{ $item->name }}</td>
                                            <td>
                                                <a onclick="return confirm('Bạn có muốn xóa thương hiệu này không?')"
                                                    href="{{ route("admin.product.trademarkDelete",['id'=>$item->id]) }}" class="btn btn-danger btn-sm rounded-0 text-white"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
