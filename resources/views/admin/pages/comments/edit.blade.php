@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa bình luận')

@section('content')
<div class="container">
    <h3 class="mb-4 text-primary"><i class="bi bi-pencil-square"></i> Chỉnh sửa bình luận</h3>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="content" class="form-label">Nội dung bình luận</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required>{{ old('content', $comment->content) }}</textarea>
                    @error('content')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Cập nhật bình luận
                    </button>
                    <a href="{{ route('admin.comments.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
