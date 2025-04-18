@extends('admin.layouts.app')
@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title text-primary fw-bold mb-0">Chi Tiết Đơn Hàng #{{ $order->id }}</h5>
                </div>

                <div class="card-body">
                    {{-- Thông tin khách hàng --}}
                    <h6 class="fw-bold mb-3 text-uppercase text-muted">Thông tin khách hàng</h6>
                    <ul class="list-unstyled mb-4">
                        <li><strong>Họ tên:</strong> {{ $order->user->name }}</li>
                        <li><strong>Email:</strong> {{ $order->user->email }}</li>
                        <li><strong>Điện thoại:</strong> {{ $order->userAddress->phone ?? '---' }}</li>
                    </ul>

                    {{-- Địa chỉ giao hàng --}}
                    <h6 class="fw-bold mb-3 text-uppercase text-muted">Địa chỉ giao hàng</h6>
                    <p>
                        {{ $order->userAddress->address_line ?? '---' }},
                        {{ $order->userAddress->ward ?? '' }},
                        {{ $order->userAddress->district ?? '' }},
                        {{ $order->userAddress->city ?? '' }}
                    </p>

                    {{-- Phương thức vận chuyển & mã giảm giá --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Phương thức vận chuyển</h6>
                            <p>{{ $order->shippingMethod->name ?? '---' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted">Mã giảm giá</h6>
                            <p>{{ $order->voucher->code ?? '---' }}</p>
                        </div>
                    </div>

                    {{-- Trạng thái đơn hàng --}}
                    @php
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'shipped' => 'Đang giao',
                            'delivered' => 'Đã giao',
                            'cancelled' => 'Đã hủy',
                        ];
                        $statusColors = [
                            'pending' => 'secondary',
                            'confirmed' => 'primary',
                            'shipped' => 'info',
                            'delivered' => 'success',
                            'cancelled' => 'danger',
                        ];
                    @endphp
                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </p>

                    {{-- Danh sách sản phẩm --}}
                    <h6 class="fw-bold mb-3 text-uppercase text-muted">Sản phẩm</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Biến thể</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-start">{{ $item->product->name ?? '---' }}</td>
                                        <td>
                                            @if($item->productVariant)
                                                {{ $item->productVariant->variant_name }}
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }}₫</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="fw-bold text-success">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @php
                        $subtotal = $order->orderItems->sum(function ($item) {
                            return $item->price * $item->quantity;
                        });

                        $discount = $order->discount_amount ?? 0;
                        $shipping = $order->shipping_fee ?? 0;

                        $finalAmount = $subtotal - $discount + $shipping;
                    @endphp

                    {{-- Tổng tiền --}}
                    <div class="mt-4">
                        <p><strong>Tạm tính:</strong> {{ number_format($subtotal, 0, ',', '.') }}₫</p>
                        <p><strong>Giảm giá:</strong> -{{ number_format($discount, 0, ',', '.') }}₫</p>
                        <p><strong>Phí vận chuyển:</strong> {{ number_format($shipping, 0, ',', '.') }}₫</p>
                        <h5 class="fw-bold text-success">Tổng thanh toán: {{ number_format($finalAmount, 0, ',', '.') }}₫
                        </h5>
                    </div>


                    {{-- Thông tin thanh toán --}}
                    <h6 class="fw-bold mt-4 mb-3 text-uppercase text-muted">Thông tin thanh toán</h6>
                    <p><strong>Phương thức:</strong> {{ $order->payment->payment_method ?? '---' }}</p>
                    <p><strong>Trạng thái:</strong> {{ ucfirst($order->payment->status ?? '---') }}</p>

                    @if($order->payment && $order->payment->details)
                        <div class="border p-3 mt-2 bg-light">
                            <h6 class="fw-bold">Chi tiết giao dịch</h6>
                            <p><strong>Mã giao dịch:</strong> {{ $order->payment->details->transaction_id ?? '---' }}</p>
                            <p><strong>Thông tin thêm:</strong> {{ $order->payment->details->payment_info ?? '---' }}</p>
                        </div>
                    @endif

                    {{-- Nút quay lại --}}
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection