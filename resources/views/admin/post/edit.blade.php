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
                Cập nhật bài viết
            </div>
            <div class="card-body">
                <form id="upload-post" action="{{ route('admin.post.update', ['id' => "{$post->id}"]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tiêu đề bài viết</label>
                        <input value="{{ $post->title }}" class="form-control" type="text" name="title"
                            id="name">
                    </div>
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div id="uploadFile">
                        <div class="d-flex">
                            <label class="choise-file badge badge-primary" for="file"><i
                                    class="fa-solid fa-upload"></i>Chọn ảnh cho bài viết</label>
                            <input id="file" class="d-none"type="file" name="file">
                        </div>
                        @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div id="store-img">
                            <img src="{{ asset("{$post->thumb}") }}" alt="" width="150" height="150">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc">Mô tả bài viết</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30" rows="5">
                            {!! $post->desc !!}
                        </textarea>
                        @error('desc')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="5">
                            {!! $post->content !!}
                        </textarea>
                    </div>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select name="cat" class="form-control" id="">
                            <option value=" ">Chọn danh mục</option>
                            @if (count($tree_post_cats) > 0)
                                @foreach ($tree_post_cats as $item)
                                    @if ($post->post_cat_id == $item['id'])
                                        @php
                                            $selected = 'selected';
                                        @endphp
                                    @else
                                        @php
                                            $selected = '';
                                        @endphp
                                    @endif
                                    <option {{ $selected }} value="{{ $item['id'] }}">{{ str_repeat('--',$item['level']).$item['cat_name'] }}
                                    </option>
                                @endforeach
                            @endif

                        </select>
                        @error('cat')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0"
                                {{ $post->status == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="1"
                                {{ $post->status == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleRadios2">
                                Công khai
                            </label>
                        </div>
                    </div>



                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function filePreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#store-img + img").remove();
                    $("#store-img").html('<img src="' + e.target.result + '" width="150" height="150"/>');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#file").change(function() {
            filePreview(this);
        })
    </script>

@endsection
