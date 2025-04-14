@extends('admin.layouts.app')

@section('title', 'Danh Sách Bài Viết')

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{-- Thông báo thành công --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Thông báo lỗi --}}
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

        {{-- Card danh sách bài viết --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh Sách Bài Viết</h5>
                <a href="{{ route('blogs.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus"></i> Thêm Bài Viết
                </a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Tiêu Đề</th>
                            <th>Tác Giả</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>{{ Str::limit($blog->title, 50) }}</td>
                                <td>{{ $blog->user->name ?? 'Không rõ' }}</td>
                                <td>
                                    <span class="badge bg-{{ $blog->status == 'published' ? 'success' : 'secondary' }}">
                                        {{-- Hiển thị trạng thái bằng tiếng Việt --}}
                                        @if ($blog->status == 'published')
                                            Đã Xuất Bản
                                        @else
                                            Nháp
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $blog->created_at ? $blog->created_at->format('d-m-Y') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i> Sửa
                                    </a>
                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                            <i class="mdi mdi-delete"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-muted text-center">Không có bài viết nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($blogs->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
