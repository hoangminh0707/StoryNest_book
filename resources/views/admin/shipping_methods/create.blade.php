@extends('admin.layouts.app')
@section('title', 'Thêm Phương Thức Vận Chuyển')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thêm Phương Thức Vận Chuyển</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('shipping-methods.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Tên --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Nhà cung cấp --}}
                    <div class="mb-3">
                        <label for="provider" class="form-label">Nhà Cung Cấp</label>
                        <input type="text" name="provider" class="form-control" value="{{ old('provider') }}">
                        @error('provider') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Phí mặc định --}}
                    <div class="mb-3">
                        <label for="default_fee" class="form-label">Phí Mặc Định *</label>
                        <input type="number" name="default_fee" class="form-control" value="{{ old('default_fee', 0) }}" required min="0">
                        @error('default_fee') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Mô tả --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Ảnh --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Ảnh (Logo/Icon)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Nút submit --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('shipping-methods.index') }}" class="btn btn-secondary me-2">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
