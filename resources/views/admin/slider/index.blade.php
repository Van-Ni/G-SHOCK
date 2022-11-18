@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
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
                    <div class="card-header font-weight-bold">
                        Thêm slider
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group mr-20">
                                    <label for="name">Tên slider</label>
                                    <input class="form-control" type="text" name="name" id="name">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mr-20">
                                    <label for="link">Link slider</label>
                                    <input class="form-control" type="text" name="link" id="link">
                                    @error('link')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mr-20">
                                    <label for="order">Số thứ tự</label>
                                    <input class="form-control" type="text" name="order" id="order">
                                    @error('order')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                            value="0" checked>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Chờ duyệt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                            value="1">
                                        <label class="form-check-label" for="exampleRadios2">
                                            Công khai
                                        </label>
                                    </div>
                                </div>
                                <div id="uploadFile" style="margin-right: 60px">
                                    <div class="text-center">
                                        <label class="choise-file badge badge-primary" for="file"><i
                                                class="fa-solid fa-upload"></i>Ảnh slider</label>
                                        <input id="file" class="d-none" type="file" name="file">
                                    </div>
                                    <div id="store-img" class="mx-auto">
    
                                    </div>
                                    @error('file')
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
                        DANH SÁCH
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên </th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$sliders->isEmpty())
                                    @foreach ($sliders as $item)
                                        <th>{{ $item->slider_order }}</th>
                                        <td>{{ $item->slider_name }}</td>
                                        <td>{{ $item->slider_link }}</td>
                                        {{-- bs --}}
                                        <td> <img src="{{ asset("{$item->slider_thumb}") }}" alt="" width="150"
                                                height="auto"></td>
                                        <td><span
                                                class="badge badge-{{ $item->status == 0 ? 'warning' : 'success' }}">{{ format_status($item->status) }}</span>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route("admin.slider.edit",['id' => $item->id]) }}" class="btn btn-success btn-sm rounded-0 text-white"
                                                type="button" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Bạn có muốn xóa slider này không?')"
                                                href="{{ route('admin.slider.delete', ['id' => $item->id]) }}"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
