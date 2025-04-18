@extends('admin.layouts.app')

@section('title', 'Danh Sách Mã Giảm Giá')

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

        {{-- Card danh sách --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
               
                <a href="{{ route('vouchers.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus"></i> Thêm Mới
                </a>
            </div>

            {{-- Bộ lọc --}}
            <div class="card-body">
                <form method="GET" action="{{ route('vouchers.index') }}" class="row g-2 mb-3">
                    <div class="col-md-3">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Tìm theo mã hoặc tên">
                    </div>
                    <div class="col-md-2">
                        <select name="type" class="form-select">
                            <option value="">-- Loại --</option>
                            <option value="percent" {{ request('type') == 'percent' ? 'selected' : '' }}>% (Phần trăm)</option>
                            <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>VND (Cố định)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">-- Trạng thái --</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang hoạt động</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Ngừng hoạt động</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="expires_at" value="{{ request('expires_at') }}" class="form-control" placeholder="Hết hạn">
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-secondary me-2">Lọc</button>
                        <a href="{{ route('vouchers.index') }}" class="btn btn-outline-secondary">Đặt lại</a>
                    </div>
                </form>

                {{-- Bảng danh sách --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Mã</th>
                                <th>Tên chương trình</th>
                                <th>Loại</th>
                                <th>Giá trị giảm</th>
                                <th>Giảm tối đa</th>
                                <th>Đơn tối thiểu</th>
                                <th>Số lượt</th>
                                <th>Hết hạn</th>
                                <th>Điều kiện</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vouchers as $key => $voucher)
                            <tr>
                                <td>{{ $key + $vouchers->firstItem() }}</td>
                                <td><span class="fw-bold text-primary">{{ $voucher->code }}</span></td>
                                <td>{{ $voucher->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $voucher->type == 'percent' ? 'info' : 'secondary' }}">
                                        {{ $voucher->type == 'percent' ? '%' : 'VND' }}
                                    </span>
                                </td>
                                <td>
                                    @if($voucher->type == 'percent')
                                    <span class="text-success fw-bold"> {{ (int) $voucher->value}}%</span>
                                    @else
                                    <span class="text-danger fw-bold"> {{ number_format($voucher->value, 0, ',', '.') }}đ</span>
                                    @endif
                                </td>

                                <td>{{ $voucher->max_discount_amount ? number_format($voucher->max_discount_amount) . 'Đ' : '-' }}</td>
                                <td>{{ $voucher->min_order_value ? number_format($voucher->min_order_value) . 'Đ' : '-' }}</td>
                                <td>{{ $voucher->max_usage ?? '-' }}</td>
                                <td>{{ $voucher->expires_at ? \Carbon\Carbon::parse($voucher->expires_at)->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($voucher->conditions->isEmpty())
                                    <span class="text-muted">Tất cả</span>
                                    @else
                                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                                        @foreach($voucher->conditions as $cond)
                                        @if($cond->condition_type == 'product' && $cond->product)
                                        <span class="badge bg-info">{{ $cond->product->name }}</span>
                                        @elseif($cond->condition_type == 'category' && $cond->category)
                                        <span class="badge bg-warning text-dark">{{ $cond->category->name }}</span>
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('vouchers.toggle-status', $voucher->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-check form-switch d-flex justify-content-center mb-0">
                                            <input class="form-check-input" type="checkbox" name="is_active" onchange="this.form.submit()" {{ $voucher->is_active ? 'checked' : '' }}>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                        <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <a href="{{ route('vouchers.show', $voucher->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
                                        <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-muted text-center">Không có mã giảm giá nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Phân trang --}}
                    @if ($vouchers->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $vouchers->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection