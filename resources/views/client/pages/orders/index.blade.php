@extends('client.layouts.app')

@section('content')
  <main>
    <div class="container py-4">
    <h2 class="mb-4">Đơn hàng của bạn</h2>

    @if($orders->isEmpty())
    <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
    @else

      @foreach($orders as $order)
      <a href="{{ route('orders.show', $order->id) }}">

      <div class="tab-pane fade active show" id="address-edit" role="tabpanel">
      <div class="myaccount-content text-dark">
      <h5>Mã đơn hàng #{{ $order->order_code }} <span
        class="badge bg-{{ $statusColors[$order->status] ?? 'primary' }}">{{ $statusLabels[$order->status] ?? $order->status }}</span>

      </h5>

      <info>
      <p><strong>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</strong></p>
      @foreach($order->orderItems as $item)
      <p>{{ $item->product_name }} - SL: {{ $item->quantity }} - {{ number_format($item->price) }} VND</p>
      @endforeach
      </info>
      </div>
      </a>
      @endforeach
    @endif
    </div>
  </main>
@endsection