@extends('admin.layouts.app')
@section('title', 'Chi Tiết Thanh Toán')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Chi Tiết Thanh Toán</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Mã Đơn Hàng:</dt>
                    <dd class="col-sm-8">{{ $payment->order->order_code ?? 'N/A' }}</dd>

                    <dt class="col-sm-4">Số Tiền:</dt>
                    <dd class="col-sm-8">{{ number_format($payment->amount, 0, ',', '.') }}₫</dd>

                    <dt class="col-sm-4">Phương Thức:</dt>
                    <dd class="col-sm-8">{{ $payment->payment_method }}</dd>

                    <dt class="col-sm-4">Trạng Thái:</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : 'warning' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Ngày Tạo:</dt>
                    <dd class="col-sm-8">{{ $payment->created_at->format('d-m-Y H:i') }}</dd>
                </dl>

                <hr>
                <h5 class="mb-3">Chi Tiết Giao Dịch</h5>
                @forelse ($payment->details as $detail)
                    <div class="mb-3 border p-3 rounded">
                        <p><strong>Mã Giao Dịch:</strong> {{ $detail->transaction_id }}</p>
                        <p><strong>Thông Tin:</strong> {{ $detail->payment_info }}</p>
                        <p><strong>Ngày:</strong> {{ $detail->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                @empty
                    <p class="text-muted">Không có chi tiết giao dịch nào.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
