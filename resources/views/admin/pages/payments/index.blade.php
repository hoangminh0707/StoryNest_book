@extends('admin.layouts.app')
@section('title', 'Thanh Toán')

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{-- THÔNG BÁO --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- PHƯƠNG THỨC THANH TOÁN --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Danh Sách Phương Thức Thanh Toán</h5>
                <a href="{{ route('admin.payment-methods.create') }}" class="btn btn-primary">Thêm Phương Thức</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Mã</th>
                            <th>Ảnh</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($methods as $index => $method)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->code }}</td>
                            <td>
                                @if ($method->image)
                                <img src="{{ asset('storage/' . $method->image) }}" alt="Logo" width="50">
                                @else
                                <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.payment-methods.toggle-status', $method->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <div class="form-check form-switch d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" name="is_active"
                                            onchange="this.form.submit()" {{ $method->is_active ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>

                            <td>{{ $method->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil"></i></a>
                                <form action="{{ route('admin.payment-methods.destroy', $method->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" type="submit"><i class="mdi mdi-delete"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Không có phương thức thanh toán nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- PHÂN TRANG --}}
                <div class="mt-3">
                    {{ $methods->links() }}
                </div>
            </div>
        </div>

        {{-- DANH SÁCH THANH TOÁN --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Danh Sách Thanh Toán</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Mã Đơn Hàng</th>
                            <th>Số Tiền</th>
                            <th>Phương Thức</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->order->order_code ?? 'N/A' }}</td>
                            <td>{{ number_format($payment->amount, 0, ',', '.') }}₫</td>
                            <td>{{ $payment->paymentMethod->name ?? 'Không xác định' }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                    <i class="mdi mdi-eye"></i>
                                </a>
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Không có dữ liệu thanh toán.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- PHÂN TRANG --}}
                @if ($payments->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $payments->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection