@extends('admin.layouts.app')
@section('title', 'Bình Luận')

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

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Card danh sách --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh Sách Bình Luận</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Người Dùng</th>
                            <th>Nội Dung</th>
                            <th>Đối Tượng</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>{{ $comment->user->name ?? 'Ẩn danh' }}</td>
                                <td>{{ Str::limit($comment->content, 50) }}</td>
                                <td>
                                    @if ($comment->commentable)
                                        {{ class_basename($comment->commentable_type) }}: {{ $comment->commentable->name ?? 'N/A' }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($comment->is_approved)
                                        <span class="badge bg-success">Đã duyệt</span>
                                    @else
                                        <span class="badge bg-secondary">Chờ duyệt</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    @if(!$comment->is_approved)
                                        <form action="{{ route('comments.approve', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="btn btn-sm btn-success" onclick="return confirm('Duyệt bình luận này?')">
                                                <i class="mdi mdi-check"></i> Duyệt
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                            <i class="mdi mdi-delete"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted text-center">Không có bình luận nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($comments->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $comments->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
