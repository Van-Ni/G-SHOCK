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
                <div class="card text-center">
                    <div class="card-header font-weight-bold">
                        Thêm hình ảnh cho sản phẩm
                    </div>
                    <h4 class="py-2 text-primary">Tên sản phẩm:</h4>
                    <p class="text-secondary">{{ $product->product_name }}</p>
                    <div class="card-body">
                        <form action="{{ route('admin.product.storeImage',['id'=>$product->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div id="uploadFile">
                                <div class="">
                                    <label class="choise-file badge badge-primary" for="file"><i
                                            class="fa-solid fa-upload"></i>Chọn hình ảnh phụ</label>
                                    <input id="file" class="d-none" type="file" name="file">
                                </div>
                                <div id="store-img" class="mx-auto">

                                </div>
                                @error('file')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="color">Màu sản phẩm</label>
                                <select name="color" class="form-control mr-1" id="color">
                                    <option value=" ">Chọn màu</option>
                                    @if (!$colors->isEmpty())
                                        @foreach ($colors as $item)
                                            @if ($item->color_order == "#f5f0f0" )
                                                @php
                                                    $color = "color: #000";
                                                @endphp
                                                @else
                                                @php
                                                    $color = "";
                                                @endphp
                                            @endif
                                            <option id="option-color" style="background-color:{{ $item->color_order }};{{ $color }}" value="{{ $item->id }}">
                                                {{ $item->color_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            @error('color')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror --}}
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
                                    <th scope="col">Hình ảnh phụ</th>
                                    {{-- <th scope="col">Màu</th> --}}
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$thumbs->isEmpty())
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($thumbs as $item)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $stt }}</th>
                                            <td><img  style="width:100px" class="thumb"src="{{ asset("{$item->thumb_name}") }}" alt="">
                                            {{-- <td scope="row">{{ isset($item->color_name) ? $item->color_name : ''}}</td> --}}
                                            <td scope="row">{{ $item->name }}</td>
                                            <td>
                                                <a onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')"
                                                    href="{{ route("admin.product.imageDelete",['id'=>$item->id]) }}" class="btn btn-danger btn-sm rounded-0 text-white"
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
