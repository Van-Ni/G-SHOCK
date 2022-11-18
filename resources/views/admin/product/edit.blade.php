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
                Cập nhật sản phẩm
            </div>
            <div class="card-body">
                <form action="{{ route('admin.product.update', ['id' => $product->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="name">Tên sản phẩm</label>
                                <input value="{{ $product->product_name }}" class="form-control" type="text"
                                    name="name" id="name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex">
                                <div class="form-group" style="margin-right:10px">
                                    <label for="price">Giá mới</label>
                                    <input value="{{ $product->price }}" class="form-control" type="text" name="price"
                                        id="price">
                                    @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="old_price">Giá cũ</label>
                                    <input value='{{ $product->old_price }}' class="form-control" type="text"
                                        name="old_price" id="old_price">
                                    @error('old_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div id="uploadFile">
                                <div class="d-flex">
                                    <label class="choise-file badge badge-primary" for="file"><i
                                            class="fa-solid fa-upload"></i>Chọn ảnh cho sản phẩm</label>
                                    <input id="file" class="d-none" type="file" name="file">
                                </div>
                                <div id="store-img">
                                    <img style="width: 150px;height:150px" src="{{ asset("{$product->product_thumb}") }}"
                                        alt="">
                                </div>
                                @error('file')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="detail">Chi tiết sản phẩm</label>
                                <textarea name="detail" class="form-control" id="detail" cols="30" rows="5">
                                    {!! $product->detail !!}
                                </textarea>
                                @error('detail')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả sản phẩm</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">
                            {!! $product->desc !!}
                        </textarea>
                        @error('desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cat">Danh mục cha</label>
                        <select name="cat" class="form-control cat" id="cat">
                            <option value=" ">Chọn danh mục</option>
                            @if (!$product_cats->isEmpty())
                                @foreach ($product_cats as $item)
                                    @if ($product->product_cat_id == $item->id)
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                    <option {{ $selected }} value="{{ $item->id }}">
                                        {{ $item->cat_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('cat')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- <div class="form-group">
                        <label for="child-cat">Danh mục con</label>
                        <select name="child_cat" class="form-control child-cat" id="child-cat">
                            <option value=" ">Chọn danh mục con</option>
                            @if (!$child_cats->isEmpty())
                                @foreach ($child_cats as $item)
                                    @if ($product->child_cat_id == $item->id)
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                    <option {{ $selected }} value="{{ $item->id }}">
                                        {{ $item->cat_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div> --}}
                    {{-- <div class="form-group">
                        <label for="trademark">Thương hiệu</label>
                        <select name="trademark" class="form-control" id="trademark">
                            <option value=" ">Chọn danh mục</option>
                            @if (!$trademarks->isEmpty())
                                @foreach ($trademarks as $item)
                                    @if ($product->trademark_id == $item->id)
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                    <option {{ $selected }} value="{{ $item->id }}">
                                        {{ $item['trademark_name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('trademark')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1"
                                {{ $product->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                Còn hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="0" {{ $product->status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios2">
                                Hết hàng
                            </label>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("select.cat").change(function() {
                let selectedCat = $(this).children("option:selected").val();
                let data = {
                    selectedCat: selectedCat
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.product.selectedCat') }}",
                    method: "POST",
                    data: data,
                    dataType: "text",
                    success: function(data) {
                        console.log(data);
                        $(".child-cat").html(data);
                    },
                    error: function(xhr, ajaxOptions, throwError) {
                        alert(xhr.status);
                        alert(throwError);
                    },
                });
            });
        });
    </script>
@endsection
