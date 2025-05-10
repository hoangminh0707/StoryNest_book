@extends('client.layouts.app')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card text-center shadow-sm border-success">
      <div class="card-body">
        <h2 class="text-success mb-3">
        <i class="bi bi-check-circle-fill"></i> Đặt hàng thành công!
        </h2>
        <p class="mb-4 text-muted">Cảm ơn bạn đã tin tưởng và mua hàng tại StoryNest Book.</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('orders.index') }}" class="btn btn-sqr">
          <i class="bi bi-receipt-cutoff"></i> Xem đơn hàng
        </a>
        <a href="{{ route('index') }}" class="btn btn-sqr">
          <i class="bi bi-arrow-left-circle"></i> Tiếp tục mua sắm
        </a>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>

@endsection