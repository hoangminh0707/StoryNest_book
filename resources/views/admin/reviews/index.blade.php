@extends('admin.layouts.app')

@section('title', 'Quản lý đánh giá')

@section('content')
<div class="container">
    <h1>Quản lý đánh giá</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Người Dùng</th>
                <th>Sản Phẩm</th>
                <th>Đánh Giá</th>
                <th>Nội Dung</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->product->name }}</td>
                    <td>{{ $review->rating }}</td>
                    <td>{{ $review->comment }}</td>
                    <td>{{ $review->is_approved ? 'Đã Phê Duyệt' : 'Chờ Phê Duyệt' }}</td>
                    <td>
                        @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm" type="submit">Phê Duyệt</button>
                            </form>
                        @endif
                        <!-- Form for deleting the review -->
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="return confirm('Bạn có chắc chắn muốn xóa không?');" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $reviews->links() }}
</div>
@endsection
