@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')
<div class="container">
    <h1>Danh Sách Bài Viết</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Tạo Bài Viết Mới</a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tiêu Đề</th>
                <th>Người Dùng</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>{{ $blog->title }}</td>
                    <td>{{ $blog->user->name }}</td>
                    <td>{{ ucfirst($blog->status) }}</td>
                    <td>
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $blogs->links() }}
</div>
@endsection
