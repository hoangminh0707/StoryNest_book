@extends('admin.layouts.app')
@section('title', 'Quản lý Banner')

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- Thông báo --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card danh sách --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Danh sách Banner</h5>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm Banner
                    </a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th> <!-- Cột STT -->
                                <th>Tiêu đề</th>
                                <th>Hình ảnh</th>
                                <th>Link</th>
                                <th>Thứ tự</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $index => $banner) <!-- Thêm chỉ số $index để làm STT -->
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- Hiển thị STT -->
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $banner->image_url) }}" alt="Banner" width="100">
                                    </td>
                                    <td>
                                        <a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a>
                                    </td>
                                    <td>{{ $banner->order }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.banners.toggle', $banner->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" onchange="this.form.submit()" {{ $banner->status ? 'checked' : '' }}>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa banner này?')">
                                                <i class="mdi mdi-delete"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $banners->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection