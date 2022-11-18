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
                        Cập nhật danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.post.cat.update', ['id' => $post_cat->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input value="{{ $post_cat->cat_name }}" class="form-control" type="text" name="name"
                                    id="name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select name="cat" class="form-control" id="">
                                    <option value="0">Chọn danh mục</option>
                                    @if (count($tree_post_cats) > 0)
                                        @foreach ($tree_post_cats as $item)
                                            @if ($post_cat->parent_id == $item['id'])
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
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios1"
                                        value="0" {{ $post_cat->status == 0 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                        value="1" {{ $post_cat->status == 1 ? 'checked' : ''}}>
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
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($tree_post_cats) > 0)
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($tree_post_cats as $item)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $stt }}</th>

                                            <td>{{ str_repeat('--',$item['level']).$item['cat_name'] }}</td>
                                            <td>{{ $item['slug'] }}</td>
                                            <td><span
                                                    class="badge badge-{{ $item['status'] == 0 ? 'warning' : 'success' }}">{{ format_status($item['status']) }}</span>
                                            </td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>
                                                <a href="{{ route("admin.post.cat.edit",['id' => $item['id']]) }}" class="btn btn-success btn-sm rounded-0 text-white"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="alert alert-danger" role="alert" colspan="7">Không tìm thấy danh mục
                                            nào
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
