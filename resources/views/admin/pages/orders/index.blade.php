@extends('admin.layouts.app')
@section('title', 'Đơn hàng')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-primary fw-bold">Danh Sách Đơn Hàng</h5>
                </div>

                <div class="card-body">

                    {{-- Thông báo --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Khách Hàng</th>
                                    <th>Địa Chỉ</th>
                                    <th>Vận Chuyển</th>
                                    <th>Tổng</th>
                                    <th>Trạng Thái</th>
                                    <th>Ngày Tạo</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $index => $order)
                                    <tr>
                                        <td>{{ $orders->firstItem() + $index }}</td>
                                        <td class="text-start">
                                            <strong>{{ $order->full_name }}</strong><br>
                                            <small>{{ $order->user->email }}</small>
                                        </td>
                                        <td class="text-start">
                                            {{ $order->user_address ?? '---' }}<br>
                                        </td>
                                        <td>{{ $order->shippingMethod->name ?? '---' }}</td>
                                        <td class="text-start">
                                            <div>Tạm tính:
                                                <strong>{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                                            </div>
                                            <div>Giảm giá: <strong
                                                    class="text-danger">{{ number_format($order->discount_amount, 0, ',', '.') }}₫</strong>
                                            </div>
                                            <div>Phí ship:
                                                <strong>{{ number_format($order->shipping_fee, 0, ',', '.') }}₫</strong>
                                            </div>
                                            <div>Thanh toán: <strong
                                                    class="text-success">{{ number_format($order->final_amount, 0, ',', '.') }}₫</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statuses = [
                                                    'pending' => ['label' => 'Chờ xử lý', 'color' => 'secondary'],
                                                    'confirmed' => ['label' => 'Đã xác nhận', 'color' => 'primary'],
                                                    'shipped' => ['label' => 'Đang giao', 'color' => 'info'],
                                                    'delivered' => ['label' => 'Đã giao', 'color' => 'success'],
                                                    'completed' => ['label' => 'Hoàn tất', 'color' => 'dark'],
                                                    'cancelled' => ['label' => 'Đã hủy', 'color' => 'danger'],
                                                ];

                                                $status = $statuses[$order->status] ?? ['label' => ucfirst($order->status), 'color' => 'secondary'];
                                            @endphp

                                            <span class="badge bg-{{ $status['color'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>

                                        <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info ">Xem
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <!-- <a href="{{ route('admin.orders.editStatus', $order->id) }}" class="btn btn-warning btn-sm me-1">
                                                                                                            <i class="fa fa-sync-alt"></i>
                                                                                                        </a> -->

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-muted">Không có đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Phân trang --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection