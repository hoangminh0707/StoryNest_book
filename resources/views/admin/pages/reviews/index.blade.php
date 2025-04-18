@extends('admin.layouts.app')
@section('title', 'Đánh Giá Sản Phẩm')

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

            {{-- Danh sách đánh giá --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Danh Sách Đánh Giá</h5>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Người Dùng</th>
                                <th>Sản Phẩm</th>
                                <th>Sao</th>
                                <th>Bình Luận</th>
                                <th>Trạng Thái</th>
                                <th>Ngày</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                                    <td>{{ $review->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="text-warning mdi mdi-star"></i> {{-- sao đã đánh --}}
                                            @else
                                                <i class="text-muted mdi mdi-star-outline"></i> {{-- sao rỗng --}}
                                            @endif
                                        @endfor
                                    </td>

                                    <td>{{ Str::limit($review->comment, 50) }}</td>
                                    <td>
                                        @if ($review->is_approved)
                                            <span class="badge bg-success">Đã duyệt</span>
                                        @else
                                            <span class="badge bg-warning">Chờ duyệt</span>
                                        @endif
                                    </td>
                                    <td>{{ $review->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info">
                                            <i class="mdi mdi-eye"></i>
                                        </a>

                                        @if(!$review->is_approved)
                                            <a href="{{ route('admin.reviews.approve', $review->id) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="mdi mdi-check"></i>
                                            </a>
                                        @endif

                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted text-center">Không có đánh giá nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($reviews->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $reviews->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection