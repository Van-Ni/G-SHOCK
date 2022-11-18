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
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.product.storeCat') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" id="name">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select name="cat" class="form-control" id="">
                                    <option value="0">Chọn danh mục</option>
                                    @if (!empty($tree_product_cats))
                                        {}
                                        @foreach ($tree_product_cats as $item)
                                            <option value="{{ $item->id }}">
                                                {{ str_repeat('--', $item->level) . $item->cat_name }}</option>
                                        @endforeach
                                    @endif
                                    {{-- option2 --}}
                                    {{-- {!!  $htmlOptionCat !!} --}}
                                </select>
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
                                    <th scope="col">Tên</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- {{ $pages->total() }} --}}
                                @if (!empty($tree_product_cats))
                                    @php
                                        $stt = 0;
                                    @endphp
                                    @foreach ($tree_product_cats as $item)
                                        @php
                                            $stt++;
                                        @endphp
                                        <tr>
                                            <th scope="row">{{ $stt }}</th>

                                            <td>{{ str_repeat('--', $item['level']) . $item['cat_name'] }}</td>
                                            <td><img style="width:50px" src="{{ asset($item['cat_thumb']) }}" alt=""></td>
                                            <td>{{ $item['slug'] }}</td>
                                            <td><span
                                                    class="badge badge-{{ $item['status'] == 0 ? 'warning' : 'success' }}">{{ format_status($item['status']) }}</span>
                                            </td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>
                                                <a href="{{ route('admin.product.cat.edit', ['id' => $item['id']]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                                <a onclick="return confirm('Bạn có muốn xóa danh mục này không?')"
                                                    href="{{ route('admin.product.cat.delete', ['id' => $item['id']]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="alert alert-danger" role="alert" colspan="7">Danh mục trống
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
