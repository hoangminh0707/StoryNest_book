@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')
<div class="container">
    <h1>Chỉnh Sửa Bài Viết</h1>

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $blog->title }}" required>
        </div>
        <div class="form-group">
            <label for="content">Nội Dung</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $blog->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="status">Trạng Thái
            <select class="form-select" aria-label="Default select example">
                <option value="draft" {{ old('status', isset($blog) ? $blog->status : '') == 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="published" {{ old('status', isset($blog) ? $blog->status : '') == 'published' ? 'selected' : '' }}>Đã Xuất Bản</option>
              </select>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật Bài Viết</button>
    </form>
</div>

@endsection
