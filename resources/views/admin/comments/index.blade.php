@extends('admin.layouts.app')
@section('title', 'Dashboards')

@section('content')
    <div class="container">
        <h1>Danh Sách Bình Luận</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Người Dùng</th>
                    <th>Đối Tượng</th>
                    <th>Nội Dung</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ class_basename($comment->commentable) }} {{ $comment->commentable_id }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->is_approved ? 'Đã Duyệt' : 'Chưa Duyệt' }}</td>
                        <td>
                            @if(!$comment->is_approved)
                                <form action="{{ route('admin.comments.approve', $comment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Duyệt</button>
                                </form>
                            @endif
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE') <!-- Phương thức HTTP DELETE -->
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $comments->links() }}
    </div>
@endsection
