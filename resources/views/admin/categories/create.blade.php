@extends('admin.layouts.app')
@section('title', 'Thêm Danh Mục')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Thêm Danh Mục Mới</h5>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                    <i class="mdi mdi-arrow-left"></i> Quay lại
                </a>
            </div>

            <div class="card-body">
                {{-- Hiển thị lỗi --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Form thêm danh mục --}}
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Danh Mục <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="form-control" placeholder="Nhập tên danh mục" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea name="description" id="description" class="form-control" rows="3"
                                  placeholder="Nhập mô tả danh mục">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Danh Mục Cha</label>
                        <select name="parent_id" id="parent_id" class="form-select">
                            <option value="">-- Không có --</option>
                            @foreach ($categories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-content-save"></i> Lưu Danh Mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
