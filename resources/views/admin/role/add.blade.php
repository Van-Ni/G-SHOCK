@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm vai trò
            </div>

            <div class="card-body">
                <form action="{{ route('admin.role.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tên vai trò</label>
                        <input class="form-control" type="text" name="name" id="name">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="display_name">Mô tả vai trò</label>
                        <input class="form-control" type="text" name="display_name" id="display_name">
                        @error('display_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @error('permission_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="checkAll-wp">
                        <input type="checkbox" name="" id="checkAll">
                        <label for="checkAll">Chọn tất cả</label>
                    </div>
                    @foreach ($permissions as $parent)
                        <table class="table checkbox-wp">
                            <thead class="bg-info">
                                <tr class="">
                                    <th scope="col" colspan="10">
                                        <input type="checkbox" name="" class="selectAll">
                                        <label for="" class="text-white">{{ $parent->name }}</label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($parent->permissionChildrens as $child)
                                        <td><input value="{{ $child->id }}" class="checkboxAll" type="checkbox"
                                                name="permission_id[]" id="{{ $child->id }}">
                                            <label for="{{ $child->id }}"
                                                class=" text-primary">{{ $child->name }}</label>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                    <button type="submit" class="btn btn-primary" name="btn-add">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".selectAll").click(function() {
                $(this).closest(".checkbox-wp").find(".checkboxAll").prop('checked', $(this).prop(
                    'checked'));
            });
            $("#checkAll").click(function() {
                $(".checkboxAll").prop('checked', $(this).prop("checked"));
                $(".selectAll").prop('checked', $(this).prop("checked"));
            })
        });
    </script>
@endsection
