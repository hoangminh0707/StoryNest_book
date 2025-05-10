@extends('admin.layouts.app')
@section('title', 'Thuộc tính')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-0">Danh Sách Thuộc Tính</h5>
                    <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary">Thêm Thuộc Tính</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên Thuộc Tính</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributes as $index => $attribute)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>{{ $attribute->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.attributes.edit', $attribute->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách giá trị thuộc tính -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title mb-3">Danh Sách Giá Trị Thuộc Tính</h5>
                    <a href="{{ route('admin.attribute-values.create') }}" class="btn btn-primary">Thêm Giá Trị</a>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>ID Thuộc Tính</th>
                                <th>Giá Trị</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributeValues as $index => $value)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $value->attribute->name }}</td> <!-- Lấy tên thuộc tính từ bảng 'attributes' -->
                                    <td>{{ $value->value }}</td> <!-- Giá trị thuộc tính -->
                                    <td>{{ $value->created_at->format('d-m-Y') }}</td> <!-- Ngày tạo -->
                                    <td>
                                        <a href="{{ route('admin.attribute-values.edit', $value->id) }}"
                                            class="btn btn-warning btn-sm">Sửa</a>
                                        <form action="{{ route('admin.attribute-values.destroy', $value->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection