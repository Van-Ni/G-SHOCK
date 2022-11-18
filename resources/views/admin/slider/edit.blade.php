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
                        Cập nhật slider
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.slider.update',['id' => $slider->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group mr-20">
                                    <label for="name">Tên slider</label>
                                    <input class="form-control" value="{{ $slider->slider_name }}" type="text" name="name" id="name">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mr-20">
                                    <label for="link">Link slider</label>
                                    <input class="form-control" value="{{ $slider->slider_link }}" type="text" name="link" id="link">
                                    @error('link')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mr-20">
                                    <label for="order">Số thứ tự</label>
                                    <input class="form-control" value="{{ $slider->slider_order }}" type="text" name="order" id="order">
                                    @error('order')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Trạng thái</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                            value="0" {{ $slider->status == 0 ? 'checked' : ''}}>
                                        <label class="form-check-label" for="exampleRadios1">
                                            Chờ duyệt
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                            value="1" {{ $slider->status == 1 ? 'checked' : ''}}>
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
                                        <img style="width: 150px;height:150px" src="{{ asset("{$slider->slider_thumb}") }}"
                                        alt="">
                                    </div>
                                    @error('file')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
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
                                        <td> <img src="{{ asset("{$item->slider_thumb}") }}" alt="" width="100"
                                                height="100"></td>
                                        <td><span
                                                class="badge badge-{{ $item->status == 0 ? 'warning' : 'success' }}">{{ format_status($item->status) }}</span>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route("admin.slider.edit",['id' => $item->id]) }}" class="btn btn-success btn-sm rounded-0 text-white"
                                                type="button" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="fa fa-edit"></i></a>
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
