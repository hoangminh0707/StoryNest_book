@extends('admin.layouts.app')
@section('title', 'Mã Giảm Giá')

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

        {{-- Danh sách voucher --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh Sách Mã Giảm Giá</h5>
                <a href="{{ route('vouchers.create') }}" class="btn btn-primary btn-sm">
                    <i class="mdi mdi-plus"></i> Thêm Mới
                </a>
            </div>

            <div class="card-body table-responsive">

                {{-- Form tìm kiếm --}}
                <form method="GET" action="{{ route('vouchers.index') }}" class="row g-3 mb-3">
                    <div class="col-md-4">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm mã hoặc tên voucher..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-secondary"><i class="mdi mdi-magnify"></i> Tìm kiếm</button>
                    </div>
                </form>

                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Loại</th>
                            <th>Giá Trị</th>
                            <th>Áp Dụng</th>
                            <th>Lượt Dùng</th>
                            <th>Hạn</th>
                            <th>Trạng Thái</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $index => $voucher)
                        <tr>
                            <td>{{ $vouchers->firstItem() + $index }}</td>
                            <td><strong>{{ $voucher->code }}</strong></td>
                            <td>{{ $voucher->name }}</td>
                            <td>
                                <span class="badge {{ $voucher->type === 'fixed' ? 'bg-info' : 'bg-success' }}">
                                    {{ $voucher->type === 'fixed' ? 'Giảm tiền' : 'Giảm %' }}
                                </span>
                            </td>
                            <td>
                                {{ $voucher->type === 'fixed' ? number_format($voucher->value) . '₫' : $voucher->value . '%' }}
                            </td>
                            <td class="text-start">
                                @if ($voucher->conditions->isEmpty())
                                    <span class="text-muted">Tất cả sản phẩm</span>
                                @else
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($voucher->conditions as $condition)
                                            <li>
                                                @if ($condition->condition_type === 'category')
                                                    <span class="badge bg-primary">Danh mục:</span>
                                                    {{ optional($condition->category)->name }}
                                                @elseif ($condition->condition_type === 'product')
                                                    <span class="badge bg-success">Sản phẩm:</span>
                                                    {{ optional($condition->product)->name }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>{{ $voucher->max_usage }}</td>
                            <td>{{ $voucher->expires_at ? $voucher->expires_at->format('d/m/Y') : 'Không giới hạn' }}</td>
                            <td class="text-center">
                                <form action="{{ route('vouchers.toggle', $voucher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input" type="checkbox" onchange="this.form.submit()" {{ $voucher->is_active ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('vouchers.edit', $voucher->id) }}" class="btn btn-sm btn-warning">
                                    <i class="mdi mdi-pencil"></i>
                                </a>
                                <form action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-muted text-center">Không có mã giảm giá nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                @if ($vouchers->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $vouchers->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
