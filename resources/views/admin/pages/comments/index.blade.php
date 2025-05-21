@extends('admin.layouts.app')
@section('title', 'Quản lý bình luận')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bộ lọc bình luận</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.comments.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm tên người dùng hoặc nội dung...">
                    </div>

                    <div class="col-md-2">
                        <select name="is_approved" class="form-select">
                            <option value="">-- Trạng thái --</option>
                            <option value="1" {{ request('is_approved') === '1' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="0" {{ request('is_approved') === '0' ? 'selected' : '' }}>Chưa duyệt</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="commentable_type" class="form-select">
                            <option value="">-- Loại nội dung --</option>
                            <option value="App\Models\Product" {{ request('commentable_type') === 'App\Models\Product' ? 'selected' : '' }}>Sản phẩm</option>
                            <option value="App\Models\Blog" {{ request('commentable_type') === 'App\Models\Blog' ? 'selected' : '' }}>Bài viết</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i>Lọc</button>
                    </div>

                    <div class="col-md-2 d-grid">
                        <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times me-1"></i>Xóa lọc</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Danh sách bình luận</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Người bình luận</th>
                            <th>Nội dung</th>
                            <th>Loại</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commentsQuery as $comment)
                            <tr>
                                <td>{{ $comment->user->name ?? 'Ẩn danh' }}</td>
                                <td>{{ Str::limit($comment->content, 50) }}</td>
                                <td>
                                    @if($comment->commentable_type === 'App\Models\Product')
                                        <span class="badge bg-info">Sản phẩm</span>
                                    @elseif($comment->commentable_type === 'App\Models\Blog')
                                        <span class="badge bg-success">Bài viết</span>
                                    @else
                                        <span class="badge bg-secondary">Khác</span>
                                    @endif
                                </td>
                                <td>
                                    @if($comment->is_approved)
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Chưa duyệt</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.comments.show', $comment->id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($comment->is_approved)
                                        <a href="{{ route('admin.comments.disapprove', $comment->id) }}" class="btn btn-sm btn-secondary me-1">
                                            <i class="fas fa-times-circle"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('admin.comments.approve', $comment->id) }}" class="btn btn-sm btn-success me-1">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Không có bình luận nào phù hợp.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $commentsQuery->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
