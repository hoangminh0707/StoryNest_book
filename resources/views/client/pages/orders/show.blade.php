@extends('client.layouts.app')

@section('content')
  <style>
    .order-details-wrap {
    padding: 30px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    font-size: 15px;
    }

    .order-section {
    margin-bottom: 30px;
    }

    .section-title {
    font-weight: bold;
    margin-bottom: 15px;
    border-bottom: 2px solid #eee;
    padding-bottom: 5px;
    font-size: 16px;
    }

    .order-info li {
    margin-bottom: 8px;
    }

    .order-items .order-item {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px dashed #ddd;
    }

    .text-success {
    color: #28a745;
    }
  </style>
  <div class="container py-4">
    <h2 class="mb-4">Chi tiết đơn hàng #{{ $order->order_code }}</h2>

    <div class="order-details-wrap">

    {{-- Thông tin giao hàng --}}
    <div class="order-section">
      <h4 class="section-title">📦 Thông tin giao hàng</h4>
      <ul class="order-info">
      <li><strong>Người nhận:</strong> {{ $order->full_name }}</li>
      <li><strong>Số điện thoại:</strong> {{ $order->phone }}</li>
      <li><strong>Địa chỉ:</strong> {{ $order->user_address }}</li>
      </ul>
    </div>

    {{-- Đơn vị vận chuyển --}}
    <div class="order-section">
      <h4 class="section-title">🚚 Vận chuyển</h4>
      <ul class="order-info">
      <li><strong>Đơn vị:</strong> {{ $order->shippingMethod->name }}</li>
      <li><strong>Mô tả:</strong> {{ $order->shippingMethod->description }}</li>
      <li><strong>Phí:</strong> {{ number_format($order->shipping_fee) }} VND</li>
      </ul>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="order-section">
      <h4 class="section-title">🛒 Sản phẩm</h4>
      <div class="order-items">
      @foreach($order->orderItems as $item)
      @php
      $productImage = $item->product?->thumbnail
      ?? $item->productVariant?->image
      ?? asset('images/no-image.png'); // ảnh mặc định nếu không có
      @endphp
      <a href="{{ route('product.show', $item->product->slug) }}">
        <div class="order-item d-flex align-items-start mb-3 text-dark">
        <img src="{{ Storage::url($productImage->image_path) }}" alt="{{ $item->product_name }}"
        style="width: 60px; height: 60px; object-fit: cover;" class="me-3 rounded border">

        <div class="flex-grow-1">
        <strong>{{ $item->product_name }}</strong><br>
        SL: {{ $item->quantity }} × {{ number_format($item->price) }} VND
        </div>

        <div class="text-end" style="min-width: 100px;">
        <strong>{{ number_format($item->total) }} VND</strong>
        </div>
        </div>
      </a>
    @endforeach
      </div>
    </div>


    {{-- Thông tin thanh toán --}}
    <div class="order-section">
      <h4 class="section-title">💳 Thanh toán</h4>
      <ul class="order-info">
      <li><strong>Tạm tính:</strong> {{ number_format($order->total_amount) }} VND</li>


      <li><strong>Giảm giá:</strong> – {{ number_format($order->discount_amount) ?? '0' }} VND</li>

      <li><strong>Phí vận chuyển:</strong> {{ number_format($order->shipping_fee) }} VND</li>

      <li><strong>Thành tiền:</strong>
        <span class="text-success">{{ number_format($order->final_amount) }} VND</span>
      </li>

      <li><strong>Phương thức:</strong> {{ $order->payment->paymentMethod->name ?? '---' }}</li>

      <li><strong>Trạng thái:</strong>
        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} text-white">
        {{ ucfirst($statusLabels[$order->status] ?? $order->status) }}
        </span>
      </li>

      <li><strong>Đặt lúc:</strong> {{ $order->created_at->format('H:i d/m/Y') }}</li>
      </ul>
    </div>


    @if (in_array($order->status, ['pending', 'confirmed']))
    <div class="mt-4">
      <form action="{{ route('orders.cancel', $order->id) }}" method="POST"
      onsubmit="return confirm('Bạn có chắc muốn huỷ đơn hàng này?');">
      @csrf
      @method('PUT')
      <button type="submit" class="btn btn-sqr">❌ Huỷ đơn hàng</button>
      </form>
    </div>
    @endif
    </div>


  @endsection