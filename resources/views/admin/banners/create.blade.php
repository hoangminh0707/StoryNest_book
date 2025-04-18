@extends('admin.layouts.app')

@section('title', 'Tạo Banner Mới')

@section('content')
<div class="container">
    <h1>Tạo Banner Mới</h1>

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="image_url">Hình Ảnh</label>
            <input type="file" class="form-control" id="image_url" name="image_url" required>
        </div>
        <div class="form-group">
            <label for="link">Liên Kết</label>
            <input type="url" class="form-control" id="link" name="link" required>
        </div>
        <div class="form-group">
            <label for="order">Thứ Tự</label>
            <input type="number" class="form-control" id="order" name="order" value="0" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu Banner</button>
    </form>
</div>
@endsection
