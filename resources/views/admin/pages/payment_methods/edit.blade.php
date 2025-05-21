@extends('admin.layouts.app')

@section('title', 'Chỉnh Sửa Phương Thức Thanh Toán')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Chỉnh Sửa Phương Thức Thanh Toán</h2>
    
    <form action="{{ route('admin.payment-methods.update', $method->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">

                <!-- Tên phương thức -->
                <div class="form-group">
                    <label for="name">Tên phương thức</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $method->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mã phương thức -->
                <div class="form-group">
                    <label for="code">Mã phương thức</label>
                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $method->code) }}" required>
                    @error('code')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $method->description) }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Hình ảnh -->
                <div class="form-group">
                    <label for="image">Hình ảnh</label>
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    @if ($method->image)
                        <div class="mt-2">
                            <img src="{{ Storage::url($method->image) }}" alt="Image" class="img-thumbnail" style="width: 100px;">
                        </div>
                    @endif
                </div>

                <!-- Trạng thái kích hoạt -->
                <div class="form-group form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $method->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Kích hoạt</label>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                <a href="{{ route('admin.payment-methods.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>
</div>
@endsection
