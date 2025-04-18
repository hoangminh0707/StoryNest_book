
<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

<div class="container py-4">
  <h2 class="mb-4">Thanh toán</h2>

<<<<<<< HEAD
<section class="hero-section position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>Thanh toán</h1>
            <div class="breadcrumbs">
              <span class="item text-decoration-underline">Thanh toán</span>
            </div>
          </div>
=======
  <!-- Thông tin khách hàng -->
  <div class="card mb-4">
    <div class="card-header bg-primary text-white">Thông tin giao hàng</div>
    <div class="card-body">
      @if ($userAddresses->isEmpty())
        <div class="alert alert-warning">
          Bạn chưa có địa chỉ giao hàng. <a href="{{ route('address.create') }}" class="alert-link">Thêm địa chỉ ngay</a>.
>>>>>>> 52a20b2e4275f828d69d7e21cf4676d4abf41dd5
        </div>
      @else

              @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            @if (session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

        <form action="{{ route('checkout.submit') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label class="form-label">Chọn địa chỉ giao hàng:</label>
            @foreach($userAddresses as $address)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="address_id" id="address_{{ $address->id }}" value="{{ $address->id }}" {{ $address->is_default ? 'checked' : '' }}>
                <label class="form-check-label" for="address_{{ $address->id }}">
                  {{ $address->full_name }} - {{ $address->phone }} <br>
                  {{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}
                </label>
              </div>
            @endforeach
          </div>

          <!-- Đơn vị vận chuyển -->
          <div class="mb-3">
            <label class="form-label">Chọn đơn vị vận chuyển:</label>
            @foreach($shippingMethods as $method)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="shipping_method_id" id="shipping_{{ $method->id }}" value="{{ $method->id }}" data-fee="{{ $method->default_fee }}">
                <label class="form-check-label" for="shipping_{{ $method->id }}">
                  <strong>{{ $method->name }}</strong> - {{ number_format($method->default_fee) }} VND <br>
                  {{ $method->description }}
                </label>
              </div>
            @endforeach
          </div>

          <!-- Phương thức thanh toán -->
          <div class="mb-3">
            <label class="form-label">Chọn phương thức thanh toán:</label>
            @foreach($paymentMethods as $method)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" id="payment_{{ $method->id }}" value="{{ $method->code }}" {{ $loop->first ? 'checked' : '' }}>
                <label class="form-check-label" for="payment_{{ $method->id }}">
                  {{-- @if($method->image)
                    <img src="{{ asset('storage/' . $method->image) }}" alt="{{ $method->name }}" width="50">
                  @endif --}}
                  <strong>{{ $method->name }}</strong><br>
                  {{ $method->description }}
                </label>
              </div>
            @endforeach
          </div>

          <!-- Danh sách sản phẩm trong giỏ hàng -->
          <div class="card mb-3">
            <div class="card-header bg-secondary text-white">Sản phẩm</div>
            <ul class="list-group list-group-flush">
              
              @php $total = 0; @endphp
              @foreach($cartItems as $item)
                @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <strong>{{ $item->product->name }}</strong><br>
                    Số lượng: {{ $item->quantity }}<br>
                    Giá: {{ number_format($item->price) }} VND
                  </div>
                  <div><strong>{{ number_format($subtotal) }} VND</strong></div>
                </li>
              @endforeach
            </ul>
          </div>

          <!-- Tổng tiền -->
          <div class="card">
            <div class="card-body">
              <p><strong>Tạm tính:</strong> <span id="subtotal">{{ number_format($total) }} VND</span></p>
              <p><strong>Phí vận chuyển:</strong> <span id="shipping_fee">0 VND</span></p>
              <hr>
              <p><strong>Tổng cộng:</strong> <span id="total_amount">{{ number_format($total) }} VND</span></p>
            </div>
          </div>

          <button type="submit" class="btn btn-success mt-3">Tiến hành thanh toán</button>
        </form>
      @endif
    </div>
  </div>
</div>

<script>
  const shippingRadios = document.querySelectorAll('input[name="shipping_method_id"]');
  const shippingFeeElement = document.getElementById('shipping_fee');
  const totalAmountElement = document.getElementById('total_amount');
  const subtotal = {{ $total }};

  shippingRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      const fee = parseInt(radio.dataset.fee);
      shippingFeeElement.textContent = fee.toLocaleString('vi-VN') + ' VND';
      totalAmountElement.textContent = (subtotal + fee).toLocaleString('vi-VN') + ' VND';
    });
  });
</script>

@endsection
