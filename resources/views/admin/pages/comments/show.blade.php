@extends('admin.layouts.app')

@section('title', 'Chi tiết bình luận')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary"><i class="bi bi-chat-dots"></i> Chi tiết bình luận</h3>

    {{-- Thông tin bình luận --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div>
                <strong>{{ $comment->user->name ?? 'Khách' }}</strong> đã bình luận vào 
                @if ($comment->commentable_type === 'App\Models\Product')
                    <span class="badge bg-info text-dark">Sản phẩm: {{ $comment->commentable->name ?? '' }}</span>
                @elseif ($comment->commentable_type === 'App\Models\Blog')
                    <span class="badge bg-warning text-dark">Bài viết: {{ $comment->commentable->title ?? '' }}</span>
                @endif
            </div>
            <small class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
        </div>
        <div class="card-body">
            <p><strong>Nội dung:</strong></p>
            <div class="p-3 bg-light rounded border">{{ $comment->content }}</div>

            <p class="mt-3"><strong>Trạng thái:</strong>
                @if ($comment->is_approved)
                    <span class="badge bg-success">Đã duyệt</span>
                @else
                    <span class="badge bg-danger">Chưa duyệt</span>
                @endif
            </p>
        </div>
    </div>

    {{-- Form trả lời --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-reply-fill"></i> Trả lời bình luận
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.comments.reply', $comment->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="reply_content" class="form-label">Nội dung trả lời</label>
                    <textarea name="reply_content" id="reply_content" rows="4" class="form-control" required>{{ old('reply_content') }}</textarea>
                </div>
                <button type="submit" class="btn btn-success"><i class="bi bi-send"></i> Gửi trả lời</button>
            </form>
        </div>
    </div>

    {{-- Danh sách phản hồi --}}
    @if ($comment->replies->count())
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-chat-left-dots"></i> Các phản hồi ({{ $comment->replies->count() }})
            </div>
            <div class="card-body">
                @foreach ($comment->replies as $reply)
                    <div class="mb-4 pb-2 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $reply->user->name ?? 'Khách' }}</strong>
                            <small class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <p class="mt-2">{{ $reply->content }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary mt-4">
        <i class="bi bi-arrow-left"></i> Quay lại danh sách
    </a>
</div>
@endsection
