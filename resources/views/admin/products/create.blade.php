@extends('admin.layouts.app')
@section('title', 'Thêm sản phẩm')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold text-primary">Thêm Sản Phẩm Mới</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Tên sản phẩm --}}
                    <div class="mb-3">
                        <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>

                    {{-- Mô tả --}}
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    {{-- Giá --}}
                    <div class="mb-3">
                        <label class="form-label">Giá (VND) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" required value="{{ old('price') }}">
                    </div>

                    {{-- Danh mục --}}
                    <div class="mb-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tác giả --}}
                    <div class="mb-3">
                        <label class="form-label">Tác giả</label>
                        <select name="author_id" class="form-select">
                            <option value="">-- Chọn tác giả --</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nhà xuất bản --}}
                    <div class="mb-3">
                        <label class="form-label">Nhà xuất bản</label>
                        <select name="publisher_id" class="form-select">
                            <option value="">-- Chọn NXB --</option>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher->id }}" {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                                    {{ $publisher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Ảnh sản phẩm --}}
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="images[]" multiple class="form-control" required accept="image/*" onchange="previewImages(event)">
                        <div class="mt-2" id="preview-area" style="display: flex; flex-wrap: wrap; gap: 10px;"></div>
                    </div>

                    {{-- Chọn thumbnail --}}
                    <div class="mb-3">
                        <label class="form-label d-block">Chọn 1 ảnh làm thumbnail (nếu có)</label>
                        <small class="text-muted">Sau khi chọn ảnh, tick vào ảnh bạn muốn đặt làm thumbnail</small>
                        {{-- You can enhance this with JS to toggle thumbnails if needed --}}
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Lưu</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Script preview ảnh --}}
@push('scripts')
<script>
    function previewImages(event) {
        const files = event.target.files;
        const preview = document.getElementById('preview-area');
        preview.innerHTML = '';
        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.width = 80;
                img.height = 80;
                img.classList.add('rounded', 'shadow-sm');
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
@endsection
