@extends('client.layouts.app')

@section('content')
  @php
    $groupedOrders = $orders->groupBy('status');
    $tabs = [
    'all' => 'Tất cả',
    'pending' => 'Chờ xác nhận',
    'confirmed' => 'Đã xác nhận',
    'shipped' => 'Đang giao',
    'delivered' => 'Đã giao',
    'cancelled' => 'Đã hủy'
    ];
  @endphp


  <main>
    <div class="container py-4">
    <h2 class="mb-4">Đơn hàng của bạn</h2>

    @if($orders->isEmpty())
    <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @else
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" role="tablist">
      @foreach($tabs as $status => $label)
      <li class="nav-item" role="presentation">
      <button class="nav-link @if ($loop->first) active @endif" data-bs-toggle="tab"
      data-bs-target="#tab-{{ $status }}" type="button" role="tab">
      {{ $label }}
      </button>
      </li>
    @endforeach
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
      @foreach($tabs as $status => $label)
      @php
      $orderList = $status === 'all' ? $orders : ($groupedOrders[$status] ?? collect());
      @endphp

      <div class="tab-pane fade @if ($loop->first) show active @endif" id="tab-{{ $status }}" role="tabpanel">
      @forelse($orderList as $order)
      <a href="{{ route('orders.show', $order->id) }}" class="text-decoration-none">
      <div class="myaccount-content text-dark border p-3 mb-3 rounded">
      <h5>
      Mã đơn hàng #{{ $order->order_code }}
      <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
      {{ $tabs[$order->status] ?? ucfirst($order->status) }}
      </span>
      </h5>
      <p><strong>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</strong></p>

      @foreach($order->orderItems as $item)
      @php
      $productImage = $item->product?->thumbnail
      ?? $item->productVariant?->image
      ?? null;
      @endphp

      <div class="d-flex align-items-center mb-2">
      <img src="{{ $productImage ? Storage::url($productImage->image_path) : asset('images/no-image.png') }}"
      alt="{{ $item->product_name }}" style="width: 60px; height: 60px; object-fit: cover;"
      class="me-2 rounded border">
      <div>
      <p class="mb-0">{{ $item->product_name }}</p>
      @if ($item->variant && $item->variant->attributeValues->isNotEmpty())
      <span class="cart-variran">
      Loại : {{ $item->variant->attributeValues->pluck('value')->join(' - ') }}
      </span>
      @else
      <span class="cart-variran">Loại : Mặc định</span>
      @endif
      <br>
      <small>SL: {{ $item->quantity }} – {{ number_format($item->price) }} VND</small>
      </div>
      </div>
      @endforeach
      </div>
      </a>
      @empty
      <div class="alert alert-warning">Không có đơn hàng nào ở trạng thái "{{ $label }}".</div>
      @endforelse
      </div>
    @endforeach
    </div>
    @endif
    </div>
  </main>


@endsection