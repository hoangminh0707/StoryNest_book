@extends('admin.layouts.app') <!-- Kiểm tra lại đường dẫn tới layout -->

@section('title', 'Tạo Bài Viết Mới') <!-- Cập nhật title của trang -->

@section('content')
<div class="container">
    <h1>Tạo Bài Viết Mới</h1>

    <form action="{{ route('blogs.store') }}" method="POST"> <!-- Đảm bảo rằng route chính xác -->
        @csrf
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="status">Trạng Thái
            <select class="form-select" aria-label="Default select example">
                <option value="draft" {{ old('status', isset($blog) ? $blog->status : '') == 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="published" {{ old('status', isset($blog) ? $blog->status : '') == 'published' ? 'selected' : '' }}>Đã Xuất Bản</option>
              </select>
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Lưu Bài Viết</button>
    </form>
</div>
@endsection
