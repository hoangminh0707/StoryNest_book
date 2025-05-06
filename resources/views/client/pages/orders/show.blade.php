@extends('client.layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">Chi tiết đơn hàng #{{ $order->id }}</h2>

  <!-- Thông tin giao hàng -->
  <div class="card mb-4">
    <div class="card-header bg-primary text-white">Thông tin giao hàng</div>
    <div class="card-body">
      <p><strong>Người nhận:</strong> {{ $order->userAddress->full_name }}</p>
      <p><strong>Số điện thoại:</strong> {{ $order->userAddress->phone }}</p>
      <p><strong>Địa chỉ:</strong> {{ $order->userAddress->address_line }}, {{ $order->userAddress->ward }}, {{ $order->userAddress->district }}, {{ $order->userAddress->city }}</p>
    </div>
  </div>

  <!-- Đơn vị vận chuyển -->
  <div class="card mb-4">
    <div class="card-header bg-info text-white">Vận chuyển</div>
    <div class="card-body">
      <p><strong>Đơn vị:</strong> {{ $order->shippingMethod->name }}</p>
      <p><strong>Mô tả:</strong> {{ $order->shippingMethod->description }}</p>
      <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee) }} VND</p>
    </div>
  </div>

  <!-- Sản phẩm -->
  <div class="card mb-4">
    <div class="card-header bg-secondary text-white">Sản phẩm</div>
    <ul class="list-group list-group-flush">
      @foreach($order->orderItems as $item)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ $item->product_name }}</strong><br>
            Số lượng: {{ $item->quantity }}<br>
            Giá: {{ number_format($item->price) }} VND
          </div>
          <div><strong>{{ number_format($item->total) }} VND</strong></div>
        </li>
      @endforeach
    </ul>
  </div>

  <!-- Thanh toán -->
  <div class="card mb-4">
    <div class="card-header bg-dark text-white">Thanh toán</div>
    <div class="card-body">
      <p><strong>Tạm tính:</strong> {{ number_format($order->total_amount) }} VND</p>
      <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee) }} VND</p>
      <hr>
      <p><strong>Thành tiền:</strong> {{ number_format($order->final_amount) }} VND</p>
      <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($order->payment->payment_method) }}</p>
      <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
      <p><strong>Thời gian đặt hàng:</strong> {{ $order->created_at->format('H:i d/m/Y') }}</p>
    </div>
  </div>
</div>
@endsection
