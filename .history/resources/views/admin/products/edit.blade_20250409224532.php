@extends('admin.layouts.app')
@section('title', 'Sản phẩm')
@section('content')

 
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Sản Phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô Tả Sản Phẩm <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            <div class="text-end">
                                <small id="charCount" class="text-muted">0/300 ký tự</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Danh Mục</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == old('category_id', $product->category_id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="author_id" class="form-label">Tác Giả</label>
                            <select name="author_id" class="form-control">
                                <option value="">-- Không có --</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->id }}" {{ $author->id == old('author_id', $product->author_id) ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="publisher_id" class="form-label">Nhà Xuất Bản</label>
                            <select name="publisher_id" class="form-control">
                                <option value="">-- Không có --</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" {{ $publisher->id == old('publisher_id', $product->publisher_id) ? 'selected' : '' }}>
                                        {{ $publisher->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Hình ảnh hiện tại --}}
                        <div class="mb-3">
                            <label class="form-label">Hình ảnh hiện tại</label>
                            <div class="row">
                                @foreach($product->images as $image)
                                    <div class="col-md-3 position-relative mb-3">
                                        <img src="{{ Storage::url($image->image_path) }}" class="img-fluid rounded border" style="height: 120px; object-fit: cover;">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="radio" name="thumbnail" value="{{ $image->id }}" {{ $image->is_thumbnail ? 'checked' : '' }}>
                                            <label class="form-check-label small">Ảnh đại diện</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                                            <label class="form-check-label text-danger small">Xóa ảnh</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Upload hình mới --}}
                        <div class="mb-3">
                            <label for="images" class="form-label">Tải lên ảnh mới</label>
                            <input type="file" name="images[]" class="form-control" multiple accept="image/*" onchange="previewNewImages(event)">
                            <div id="preview-area" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save me-1"></i> Cập nhật sản phẩm</button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </div>
            </form>
     

{{-- Script --}}
<script>
    // Giới hạn mô tả
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    const maxLength = 300;

    descriptionField.addEventListener('input', () => {
        const currentLength = descriptionField.value.length;
        charCount.textContent = `${currentLength}/${maxLength} ký tự`;
    });

    // Preview ảnh mới
    function previewNewImages(event) {
        const files = event.target.files;
        const preview = document.getElementById('preview-area');
        preview.innerHTML = '';

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded', 'border', 'shadow-sm', 'me-2');
                img.style.height = '80px';
                img.style.objectFit = 'cover';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endsection
