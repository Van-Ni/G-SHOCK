@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhật trang
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-body">
                <form action="{{ url("admin/page/update/{$page->id}" ) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề trang</label>
                        <input class="form-control" type="text" name="title" id="title" value="{{ $page->title }}">
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <textarea name="content" class="form-control" id="mytextarea" cols="30" rows="5">
                            {!! $page->content !!}
                        </textarea>
                        @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0"
                            {{ $page->status == 0 ? 'checked' : ''}}>
                            <label class="form-check-label" for="exampleRadios1">
                                Chờ duyệt
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                value="1" {{ $page->status == 1 ? 'checked' : ''}}>
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
@endsection
