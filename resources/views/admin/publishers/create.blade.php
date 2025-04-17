@extends('admin.layouts.app')
@section('title', 'Thêm Nhà Xuất Bản')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        {{-- Thông báo --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Form thêm nhà xuất bản --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thêm Nhà Xuất Bản Mới</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('publishers.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Nhà Xuất Bản</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nationality" class="form-label">Quốc Gia</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality') }}">
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa Chỉ</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('publishers.index') }}" class="btn btn-secondary">
                            <i class="mdi mdi-arrow-left"></i> Quay Lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-content-save"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
