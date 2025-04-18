@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Banner')

@section('content')
<div class="container">
    <h1>Chỉnh sửa Banner</h1>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Tiêu Đề</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $banner->title }}" required>
        </div>
        <div class="form-group">
            <label for="image_url">Hình Ảnh</label>
            <input type="file" class="form-control" id="image_url" name="image_url">
            <br>
            <img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->title }}" width="100">
        </div>
        <div class="form-group">
            <label for="link">Liên Kết</label>
            <input type="url" class="form-control" id="link" name="link" value="{{ $banner->link }}" required>
        </div>
        <div class="form-group">
            <label for="order">Thứ Tự</label>
            <input type="number" class="form-control" id="order" name="order" value="{{ $banner->order }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập Nhật Banner</button>
    </form>
</div>
@endsection
