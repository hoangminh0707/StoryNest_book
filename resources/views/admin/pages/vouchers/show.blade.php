@extends('admin.layouts.app')

@section('title', 'Chi Tiết Mã Giảm Giá')

@section('content')
    <div class="container">

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Thông Tin Mã Giảm Giá</h5>
                <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary btn-sm">← Quay lại</a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Mã:</strong> <span
                            class="text-primary fw-bold">{{ $voucher->code }}</span></li>
                    <li class="list-group-item"><strong>Tên chương trình:</strong> {{ $voucher->name }}</li>
                    <li class="list-group-item"><strong>Loại:</strong>
                        {{ $voucher->type == 'percent' ? 'Phần trăm (%)' : 'Tiền mặt (VND)' }}</li>
                    <li class="list-group-item"><strong>Giá trị:</strong>
                        @if($voucher->type == 'percent')
                            {{ (int) $voucher->value }}%
                        @else
                            {{ number_format($voucher->value, 0, ',', '.') }}đ
                        @endif
                    </li>
                    <li class="list-group-item"><strong>Giảm tối đa:</strong>
                        {{ $voucher->max_discount_amount ? number_format($voucher->max_discount_amount, 0, ',', '.') . 'đ' : '-' }}
                    </li>
                    <li class="list-group-item"><strong>Đơn tối thiểu:</strong>
                        {{ $voucher->min_order_value ? number_format($voucher->min_order_value, 0, ',', '.') . 'đ' : '-' }}
                    </li>
                    <li class="list-group-item"><strong>Số lượt sử dụng tối đa:</strong> {{ $voucher->max_usage ?? '-' }}
                    </li>
                    <li class="list-group-item"><strong>Ngày hết hạn:</strong>
                        {{ $voucher->expires_at ? \Carbon\Carbon::parse($voucher->expires_at)->format('d/m/Y') : '-' }}
                    </li>
                    <li class="list-group-item"><strong>Trạng thái:</strong>
                        @if($voucher->is_active)
                            <span class="badge bg-success">Đang hoạt động</span>
                        @else
                            <span class="badge bg-secondary">Tạm dừng</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        {{-- Điều kiện áp dụng --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Điều Kiện Áp Dụng</h5>
            </div>
            <div class="card-body">
                @if($voucher->conditions->isEmpty())
                    <p class="text-muted mb-0">Áp dụng cho tất cả sản phẩm và danh mục.</p>
                @else
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($voucher->conditions as $cond)
                            @if($cond->condition_type == 'product' && $cond->product)
                                <span class="badge bg-info">{{ $cond->product->name }}</span>
                            @elseif($cond->condition_type == 'category' && $cond->category)
                                <span class="badge bg-warning text-dark">{{ $cond->category->name }}</span>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Lịch sử sử dụng --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Lịch Sử Sử Dụng</h5>
            </div>
            <div class="card-body table-responsive">
                @if($voucher->usageLogs->isEmpty())
                    <p class="text-muted text-center mb-0">Chưa có lượt sử dụng nào.</p>
                @else
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Người dùng</th>
                                <th>Đơn hàng</th>
                                <th>Số tiền giảm</th>
                                <th>Ngày sử dụng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($voucher->usageLogs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $log->user->name ?? 'Ẩn danh' }}</td>
                                    <td>#{{ $log->order->id ?? '---' }}</td>
                                    <td class="text-success fw-bold">{{ number_format($log->discount_value, 0, ',', '.') }}đ</td>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection