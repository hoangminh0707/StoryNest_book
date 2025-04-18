@extends('admin.layouts.app')
@section('title', 'Tác Giả')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- Thông báo --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card danh sách --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Danh Sách Tác Giả</h5>
                    <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm Tác Giả
                    </a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Tiểu Sử</th>
                                <th>Ngày Sinh</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($authors as $author)
                                <tr>
                                    <td>{{ $author->id }}</td>
                                    <td>{{ $author->name }}</td>
                                    <td>{{ Str::limit($author->bio, 50) }}</td>
                                    <td>{{ $author->birthdate ? \Carbon\Carbon::parse($author->birthdate)->format('d-m-Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $author->created_at ? $author->created_at->format('d-m-Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                <i class="mdi mdi-delete"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted text-center">Không có tác giả nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($authors->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $authors->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection