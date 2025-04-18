@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')
<div class="container">
    <h1>Quản lý Banner</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('banners.create') }}" class="btn btn-primary">Tạo Banner Mới</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Hình Ảnh</th>
                <th>Tiêu Đề</th>
                <th>Liên Kết</th>
                <th>Thứ Tự</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
                <tr>
                    <td><img src="{{ asset('storage/' . $banner->image_url) }}" alt="{{ $banner->title }}" width="100"></td>
                    <td>{{ $banner->title }}</td>
                    <td><a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></td>
                    <td>{{ $banner->order }}</td>
                    <td>
                        <a href="{{ route('banners.edit', $banner->id) }}" class="btn btn-warning btn-sm">Chỉnh Sửa</a>
                        <form action="{{ route('banners.destroy', $banner->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $banners->links() }}
</div>
@endsection
