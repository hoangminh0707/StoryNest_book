@extends('admin.layouts.app')
@section('title', 'Chi Tiết Đánh Giá')

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Chi Tiết Đánh Giá</h5>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">
                        <i class="mdi mdi-arrow-left"></i> Quay Lại
                    </a>
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Người Dùng:</dt>
                        <dd class="col-sm-8">{{ $review->user->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Sản Phẩm:</dt>
                        <dd class="col-sm-8">{{ $review->product->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Số Sao:</dt>
                        <dd class="col-sm-8">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="mdi mdi-star text-warning"></i>
                                @else
                                    <i class="mdi mdi-star-outline text-muted"></i>
                                @endif
                            @endfor
                        </dd>

                        <dt class="col-sm-4">Bình Luận:</dt>
                        <dd class="col-sm-8">{{ $review->comment }}</dd>

                        <dt class="col-sm-4">Trạng Thái:</dt>
                        <dd class="col-sm-8">
                            @if ($review->is_approved)
                                <span class="badge bg-success">Đã duyệt</span>
                            @else
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @endif
                        </dd>

                        <dt class="col-sm-4">Ngày Tạo:</dt>
                        <dd class="col-sm-8">{{ $review->created_at->format('d-m-Y H:i') }}</dd>
                    </dl>

                    {{-- Duyệt đánh giá nếu chưa duyệt --}}
                    @if (!$review->is_approved)
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success mt-3">
                                <i class="mdi mdi-check"></i> Duyệt Đánh Giá
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection