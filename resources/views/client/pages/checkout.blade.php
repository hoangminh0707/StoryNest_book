<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')
<style>
  .address-item:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}
.current-address {
    font-size: 14px;
}

.shipping-item:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}

.payment-item:hover {
    background-color: #f8f9fa;
    cursor: pointer;
}



</style>

  <main>
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area">
    <div class="container">
      <div class="row">
      <div class="col-12">
        <div class="breadcrumb-wrap">
        <nav aria-label="breadcrumb">
          <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
          <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
          <li class="breadcrumb-item active" aria-current="page">checkout</li>
          </ul>
        </nav>
        </div>
      </div>
      </div>
    </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- checkout main wrapper start -->
    <div class="checkout-page-wrapper section-padding">
    <div class="container">
      <div class="row">
      <div class="col-12">
        <!-- Checkout Login Coupon Accordion Start -->
        <div class="checkoutaccordion" id="checkOutAccordion">
        <div class="card">
          <h6>Have A Coupon? <span data-bs-toggle="collapse" data-bs-target="#couponaccordion">Click
            Here To Enter Your Code</span></h6>
          <div id="couponaccordion" class="collapse" data-parent="#checkOutAccordion">
          <div class="card-body">
            <div class="cart-update-option">
            <div class="apply-coupon-wrapper">
              <form action="#" method="post" class=" d-block d-md-flex">
              <input type="text" placeholder="Enter Your Coupon Code" required />
              <button class="btn btn-sqr">Apply Coupon</button>
              </form>
            </div>
            </div>
          </div>
          </div>
        </div>
        </div>
        <!-- Checkout Login Coupon Accordion End -->
      </div>
      </div>
      <div class="row">
      <!-- Checkout Billing Details -->
      <div class="col-lg-6">
        <div class="checkout-billing-details-wrap">
        <h5 class="checkout-title">Thanh toán đơn hàng</h5>
        <div class="billing-form-wrap">
          <form action="#">
          <div class="row">
          <div class="single-input-item">
            <div class="shipping-address-section p-3 bg-white shadow-sm rounded mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="mb-0">Địa chỉ giao hàng</h5>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal" class="text-primary">Thay đổi</a>
              </div>
          
              @if($defaultAddress)
              <div class="current-address">
                  <p class="fw-bold mb-1">{{ $defaultAddress->full_name }} | {{ $defaultAddress->phone }}</p>
                  <p class="mb-0">{{ $defaultAddress->address_line }}, {{ $defaultAddress->ward }}, {{ $defaultAddress->district }}, {{ $defaultAddress->city }}</p>
              </div>
              @else
              <p>Chưa có địa chỉ giao hàng. Vui lòng thêm địa chỉ!</p>
              @endif
          </div>
          
          
          </div>

          <div class="single-input-item">
            <div class="shipping-method-section p-3 bg-white shadow-sm rounded mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="mb-0">Phương thức vận chuyển</h5>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#shippingModal" class="text-primary">Thay đổi</a>
              </div>
          
              @if(session()->has('checkout_shipping_method'))
                  @php
                      $selectedShipping = $shippingMethods->where('id', session('checkout_shipping_method'))->first();
                  @endphp
                  @if($selectedShipping)
                  <div class="current-shipping">
                      <p class="fw-bold mb-1">{{ $selectedShipping->name }} ({{ number_format($selectedShipping->default_fee) }}₫)</p>
                      <p class="text-muted mb-0">{{ $selectedShipping->description }}</p>
                  </div>
                  @endif
              @else
                  <p>Chưa chọn phương thức vận chuyển.</p>
              @endif
          </div>
          
          </div>

          <div class="single-input-item">
            <div class="payment-method-section p-3 bg-white shadow-sm rounded mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="mb-0">Phương thức thanh toán</h5>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#paymentModal" class="text-primary">Thay đổi</a>
              </div>
          
              @if(session()->has('checkout_payment_method'))
                  @php
                      $selectedPayment = $paymentMethods->where('id', session('checkout_payment_method'))->first();
                  @endphp
                  @if($selectedPayment)
                  <div class="current-payment">
                      <p class="fw-bold mb-1">{{ $selectedPayment->name }}</p>
                      <p class="text-muted mb-0">{{ $selectedPayment->description }}</p>
                  </div>
                  @endif
              @else
                  <p>Chưa chọn phương thức thanh toán.</p>
              @endif
          </div>
          </div>

          <div class="single-input-item">
            <div class="voucher-section p-3 bg-white shadow-sm rounded mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="mb-0">Mã giảm giá</h5>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#voucherModal" class="text-primary">Chọn mã</a>
              </div>
          
              @if(session()->has('checkout_voucher') && isset($voucher))
                  <div class="current-voucher text-success">
                      <p class="fw-bold mb-1">{{ $voucher->code }}</p>
                      <p class="mb-0 small">
                          @if($voucher->type === 'fixed')
                              Giảm {{ number_format($voucher->value) }}₫
                          @elseif($voucher->type === 'percent')
                              Giảm {{ number_format($voucher->value) }}% (tối đa {{ number_format($voucher->max_discount_amount) }}₫)
                          @endif
                      </p>
                  </div>
              @else
                  <p class="text-muted">Chưa áp dụng mã giảm giá.</p>
              @endif
          </div>
          </div>

          </div>
          </form>
        </div>
        </div>
      </div>
                    <!-- Order Summary Details -->
                    <div class="col-lg-6">
                      <div class="order-summary-details">
                          <h5 class="checkout-title">Thông tin đơn hàng của bạn</h5>
                          <div class="order-summary-content">
                              <!-- Order Summary Table -->
                              <div class="order-summary-table table-responsive text-center">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th>Sản phẩm</th>
                                              <th>Tổng tiền</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($cartItems as $item)
                                          <tr>
                                              <td><a href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }} <strong> × {{ $item->quantity }}</strong></a>
                                                @if($item->productVariant)
                                                <br>
                                                @foreach($item->productVariant->attributeValues as $attributeValue)
                                                <span>{{ $attributeValue->attribute->name }}: {{ $attributeValue->value }}{{ !$loop->last ? ', ' : '' }}</span>
                                                @endforeach
                                                @endif
                                              </td>
                                              <td>
                                                {{ number_format($item->price * $item->quantity) }} đ
                                            </td>
                                            
                                          </tr>
                                          @endforeach
                                      </tbody>
                                      <tfoot>
                                          <tr>
                                              <td>Tạm tính</td>
                                              <td><strong>{{ number_format($cartItems->sum(fn($i) => $i->price * $i->quantity)) }}</strong></td>
                                          </tr>
                                          <tr>
                                              <td>Vận chuyển</td>
                                              <td class="d-flex justify-content-center">
                                                  <ul class="shipping-type">
                                                      <li>
                                                        @if (session('checkout_shipping_method'))
                                                        @php
                                                        $shipping = $shippingMethods->where('id', session('checkout_shipping_method'))->first();
                                                    @endphp
                                                    
                                                        <label class="custom-control-label"> {{ $shipping->name }} ({{ number_format($shipping->default_fee) }}đ)</label>
                                                        @else
                                                        <label class="custom-control-label text-muted">Chưa chọn</label>
                                                        @endif
                                                      </li>
                                                     
                                                  </ul>
                                              </td>
                                          </tr>
                                          <tr>
                                            <td>Giảm giá</td>
                                            <td class="d-flex justify-content-center">
                                                <ul class="shipping-type">
                                                    <li>
                                                      @if (session('checkout_voucher') && isset($voucher))
                                                      <label class="custom-control-label">{{ number_format($discount) }} đ</label>
                                                      
                                                      
                                                      @else
                                                      <label class="custom-control-label">Chưa chọn</label>
                                                      @endif
                                                    </li>
                                                   
                                                </ul>
                                            </td>
                                        </tr>
                                          <tr>
                                              <td>Tổng thanh toán</td>
                                              <td><strong>{{ number_format($finalTotal) }} đ</strong></td>
                                          </tr>

                                          <tr>
                                            <td>Phương thức thanh toán</td>
                                            <td>
                                                <strong>
                                                    @if($payment)
                                                        {{ $payment->name }}
                                                    @else
                                                        Chưa chọn
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                      </tfoot>
                                  </table>
                              </div>
                              <!-- Order Payment Method -->
                              <div class="order-payment-method">
                                <form action="{{ route('checkout.submit') }}" method="POST">
                                  @csrf
                              
                                  <input type="hidden" name="address_id" value="{{ session('checkout_address_id') }}">
                                  <input type="hidden" name="shipping_method_id" value="{{ session('checkout_shipping_method') }}">
                                  <input type="hidden" name="payment_method" value="{{ session('checkout_payment_method') }}">
                              
                                  <button type="submit" class="btn btn-sqr">Place Order</button>
                              </form>
                              
                              
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- checkout main wrapper end -->
  </main>
 

{{-- Model của phần chọn địa chỉ --}}
    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addressModalLabel">Chọn địa chỉ giao hàng</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
    
          <div class="modal-body">
            @foreach($addresses as $address)
                <div class="address-item mb-3 p-3 border rounded @if($defaultAddress && $defaultAddress->id == $address->id) border-primary @endif">
                    <div class="d-flex align-items-start">
                        <input type="radio" name="selected_address" id="address{{ $address->id }}" value="{{ $address->id }}" class="form-check-input mt-1 me-2" {{ $defaultAddress && $defaultAddress->id == $address->id ? 'checked' : '' }}>
                        
                        <label for="address{{ $address->id }}" class="w-100">
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold">{{ $address->full_name }} | {{ $address->phone }}</span>
                                @if($address->is_default)
                                    <span class="badge bg-success">Mặc định</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $address->address_line }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}</small>
                        </label>
                    </div>
                </div>
            @endforeach
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-sqr w-100" id="saveAddressBtn">Xác nhận địa chỉ</button>
          </div>
        </div>
      </div>
    </div>
    {{-- end model chọn địa chỉ --}}
{{-- model chọn phương thức vận chuyển --}}
    <div class="modal fade" id="shippingModal" tabindex="-1" aria-labelledby="shippingModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="shippingModalLabel">Chọn phương thức vận chuyển</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
    
          <div class="modal-body">
            @foreach($shippingMethods as $method)
                <div class="shipping-item mb-3 p-3 border rounded">
                    <div class="d-flex align-items-start">
                        <input type="radio" name="selected_shipping" id="shipping{{ $method->id }}" value="{{ $method->id }}" class="form-check-input mt-1 me-2" {{ session('checkout_shipping_method') == $method->id ? 'checked' : '' }}>
                        
                        <label for="shipping{{ $method->id }}" class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $method->name }}</strong><br>
                                    <small class="text-muted">{{ $method->description }}</small>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0">{{ number_format($method->default_fee) }}₫</p>
                                    @if($method->image)
                                        <img src="{{ Storage::url($method->image) }}" alt="{{ $method->name }}" style="width: 50px;">
                                    @endif
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-sqr w-100" id="saveShippingBtn">Xác nhận phương thức</button>
          </div>
        </div>
      </div>
    </div>
    {{-- end model chọn phương thức vận chuyển --}}

    {{-- model phương thức thanh toán --}}
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="paymentModalLabel">Chọn phương thức thanh toán</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
    
          <div class="modal-body">
            @foreach($paymentMethods as $method)
                <div class="payment-item mb-3 p-3 border rounded">
                    <div class="d-flex align-items-start">
                        <input type="radio" name="selected_payment" id="payment{{ $method->id }}" value="{{ $method->id }}" class="form-check-input mt-1 me-2" {{ session('checkout_payment_method') == $method->id ? 'checked' : '' }}>
                        
                        <label for="payment{{ $method->id }}" class="w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $method->name }}</strong><br>
                                    <small class="text-muted">{{ $method->description }}</small>
                                </div>
                                @if($method->image)
                                    <img src="{{ Storage::url($method->image) }}" alt="{{ $method->name }}" style="width: 50px;">
                                @endif
                            </div>
                        </label>
                    </div>
                </div>
            @endforeach
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-sqr w-100" id="savePaymentBtn">Xác nhận thanh toán</button>
          </div>
        </div>
      </div>
    </div>

    {{-- end model phương thức thanh toán --}}

    {{-- model chọn voucher --}}
    <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
    
          <div class="modal-header">
            <h5 class="modal-title">Chọn mã giảm giá</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>
    
          <div class="modal-body">
            @foreach($vouchers as $v)
            @php
            $isUsable = $cartTotal >= $v->min_order_value;
        @endphp
        
        <div class="voucher-item mb-3 p-3 border rounded {{ !$isUsable ? 'bg-light text-muted' : '' }}">
            <div class="d-flex align-items-start">
                <input type="radio"
                       name="selected_voucher"
                       id="voucher{{ $v->id }}"
                       value="{{ $v->id }}"
                       class="form-check-input mt-1 me-2"
                       {{ !$isUsable ? 'disabled' : '' }}
                       {{ session('checkout_voucher') == $v->id && $isUsable ? 'checked' : '' }}>
        
                <label for="voucher{{ $v->id }}" class="w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $v->code }}</strong><br>
                            <small class="text-muted">
                                {{ $v->description ?? 'Áp dụng cho đơn hàng đủ điều kiện' }}<br>
                                Đơn từ {{ number_format($v->min_order_value) }}₫
                                @if($v->expires_at)
                                    | HSD: {{ \Carbon\Carbon::parse($v->expires_at)->format('d/m/Y') }}
                                @endif
                            </small>
                        </div>
                        <div class="text-end">
                            @if($v->type === 'fixed')
                                <span class="badge bg-success">-{{ number_format($v->value) }}₫</span>
                            @else
                                <span class="badge bg-success">-{{ number_format($v->value) }}%</span>
                            @endif
                        </div>
                    </div>
                </label>
            </div>
            @if (!$isUsable)
                <small class="text-danger d-block mt-1">Đơn hàng chưa đủ điều kiện</small>
            @endif
        </div>
        
            @endforeach
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-sqr w-100" id="saveVoucherBtn">Áp dụng</button>
          </div>
    
        </div>
      </div>
    </div>
{{-- end model chon j voucher     --}}
    
    

         <script>
// js chọn địa chỉ
      document.getElementById('saveAddressBtn').addEventListener('click', function() {
    let selectedAddressId = document.querySelector('input[name="selected_address"]:checked').value;

    fetch('/checkout/update-address', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            address_id: selectedAddressId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
});
// js chọn phương thức vận chuyển
document.getElementById('saveShippingBtn').addEventListener('click', function() {
    let selectedShippingId = document.querySelector('input[name="selected_shipping"]:checked').value;

    fetch('/checkout/update-shipping', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            shipping_id: selectedShippingId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
});

//phương thức thanh toán
document.getElementById('savePaymentBtn').addEventListener('click', function() {
    let selectedPaymentId = document.querySelector('input[name="selected_payment"]:checked').value;

    fetch('/checkout/update-payment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            payment_id: selectedPaymentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
});

// js model voucher
document.getElementById('saveVoucherBtn').addEventListener('click', function () {
    const selectedVoucherId = document.querySelector('input[name="selected_voucher"]:checked')?.value;

    fetch('/checkout/update-voucher', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ voucher_id: selectedVoucherId })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload(); // reload để cập nhật giá
        }
    });
});




    </script>

  @endsection