{{-- @extends('admin.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Danh Sách Giá Trị Thuộc Tính</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="#">Giá Trị Thuộc Tính</a></li>
                                <li class="breadcrumb-item active">Danh Sách</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title mb-0">Danh Sách Giá Trị Thuộc Tính</h5>
                            <a href="{{ route('admin.attribute-values.create', $attribute) }}"
                                class="btn btn-primary">Thêm Giá Trị</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Biến Thể Sản Phẩm</th>
                                        <th>Giá Trị</th>
                                        <th>Ngày Tạo</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attributeValues as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->productVariant->variant_name }}</td>
                                        <td>{{ $value->value }}</td>
                                        <td>{{ $value->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('attributes.values.edit', [$attribute, $value]) }}"
                                                class="btn btn-warning btn-sm">Sửa</a>
                                            <form
                                                action="{{ route('attributes.values.destroy', [$attribute, $value]) }}"
                                                method="POST" style="display:inline;">
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
        </div>
    </div>
</div>
@endsection --}}