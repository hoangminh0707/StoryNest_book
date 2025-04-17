@extends('client.layouts.app')

@section('content')
<div class="container py-5">
  <div class="alert alert-success text-center">
    <h4>🎉 Đặt hàng thành công!</h4>
    <p>Cảm ơn bạn đã mua hàng tại cửa hàng của chúng tôi.</p>
    <a href="{{ route('orders.index') }}" class="btn btn-primary mt-3">Xem đơn hàng của tôi</a>
    <a href="{{ route('index') }}" class="btn btn-outline-secondary mt-3">Tiếp tục mua sắm</a>
  </div>
</div>
@endsection