@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Mã Giảm Giá')

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Chỉnh Sửa Mã Giảm Giá</h5>
                <a href="{{ route('vouchers.index') }}" class="btn btn-sm btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @php
                        $selectedProducts = old('products', $productIds ?? []);
                        $selectedCategories = old('categories', $categoryIds ?? []);
                    @endphp

                    {{-- Mã voucher --}}
                    <div class="mb-3">
                        <label for="code" class="form-label">Mã Giảm Giá <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="code"
                            class="form-control @error('code') is-invalid @enderror"
                            value="{{ old('code', $voucher->code) }}" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tên voucher --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Voucher</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $voucher->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Loại giảm giá --}}
                    <div class="mb-3">
                        <label for="type" class="form-label">Loại Giảm Giá <span class="text-danger">*</span></label>
                        <select name="type" id="type"
                            class="form-select @error('type') is-invalid @enderror" required>
                            <option value="fixed" {{ old('type', $voucher->type) === 'fixed' ? 'selected' : '' }}>Giảm Tiền</option>
                            <option value="percent" {{ old('type', $voucher->type) === 'percent' ? 'selected' : '' }}>Giảm %</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Giá trị --}}
                    <div class="mb-3">
                        <label for="value" class="form-label">Giá Trị Giảm <span class="text-danger">*</span></label>
                        <input type="number" name="value" id="value" min="1"
                            class="form-control @error('value') is-invalid @enderror"
                            value="{{ old('value', $voucher->value) }}" required>
                        @error('value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lượt dùng tối đa --}}
                    <div class="mb-3">
                        <label for="max_usage" class="form-label">Lượt Dùng Tối Đa</label>
                        <input type="number" name="max_usage" id="max_usage" min="0"
                            class="form-control @error('max_usage') is-invalid @enderror"
                            value="{{ old('max_usage', $voucher->max_usage) }}">
                        @error('max_usage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Hạn sử dụng --}}
                    <div class="mb-3">
                        <label for="expires_at" class="form-label">Hạn Sử Dụng</label>
                        <input type="date" name="expires_at" id="expires_at"
                            class="form-control @error('expires_at') is-invalid @enderror"
                            value="{{ old('expires_at', $voucher->expires_at ? $voucher->expires_at->format('Y-m-d') : '') }}">
                        @error('expires_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Trạng thái --}}
                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" class="form-check-input" name="is_active" id="is_active"
                            {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Kích hoạt</label>
                    </div>

                
                    {{-- Nút lưu --}}
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
