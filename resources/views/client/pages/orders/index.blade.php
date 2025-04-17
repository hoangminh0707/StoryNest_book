@extends('client.layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="mb-4">Đơn hàng của bạn</h2>

  @if($orders->isEmpty())
    <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
  @else
    <div class="list-group">
      @foreach($orders as $order)
        <a href="{{ route('orders.show', $order->id) }}" class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h5 class="mb-1">Mã đơn hàng #{{ $order->id }}</h5>
              <small>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</small>
            </div>
            <span class="badge bg-primary">{{ strtoupper($order->status) }}</span>
          </div>

          <ul class="mt-2 mb-0">
            @foreach($order->orderItems as $item)
              <li>{{ $item->product_name }} - SL: {{ $item->quantity }} - {{ number_format($item->price) }} VND</li>
            @endforeach
          </ul>
        </a>
      @endforeach
    </div>
  @endif
</div>
@endsection
