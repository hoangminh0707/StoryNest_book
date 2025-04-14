@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Phương Thức Vận Chuyển')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Chỉnh Sửa Phương Thức Vận Chuyển</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('shipping-methods.update', $method->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Tên --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $method->name) }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Nhà cung cấp --}}
                    <div class="mb-3">
                        <label for="provider" class="form-label">Nhà Cung Cấp</label>
                        <input type="text" name="provider" class="form-control" value="{{ old('provider', $method->provider) }}">
                        @error('provider') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Phí mặc định --}}
                    <div class="mb-3">
                        <label for="default_fee" class="form-label">Phí Mặc Định *</label>
                        <input type="number" name="default_fee" class="form-control" value="{{ old('default_fee', $method->default_fee) }}" required min="0">
                        @error('default_fee') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Mô tả --}}
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $method->description) }}</textarea>
                        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Ảnh hiện tại --}}
                    @if ($method->image)
                    <div class="mb-3">
                        <label class="form-label">Ảnh Hiện Tại</label><br>
                        <img src="{{ asset('storage/' . $method->image) }}" alt="Ảnh phương thức" class="img-thumbnail" style="max-height: 120px;">
                    </div>
                    @endif

                    {{-- Ảnh mới --}}
                    <div class="mb-3">
                        <label for="image" class="form-label">Cập Nhật Ảnh Mới</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    {{-- Nút submit --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('shipping-methods.index') }}" class="btn btn-secondary me-2">Quay lại</a>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
