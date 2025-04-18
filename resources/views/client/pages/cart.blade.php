
<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

<section class="hero-section position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>Cart</h1>
            <div class="breadcrumbs">
              <span class="item text-decoration-underline">Cart</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="cart padding-large">
    <div class="container">
      <div class="row">
        @if($cartItems->isEmpty())
        <div class="alert alert-warning">Giỏ hàng của bạn đang trống.</div>
      @else
        <div class="cart-table">
          <div class="cart-header border-bottom border-top">
            <div class="row d-flex text-capitalize">
              <h4 class="col-lg-4 py-3 m-0">Sản Phẩm</h4>
              <h4 class="col-lg-3 py-3 m-0">Số Lượng</h4>
              <h4 class="col-lg-4 py-3 m-0">Tổng Giá</h4>
            </div>
          </div>

          
         

          @foreach ($cartItems as $item)
          <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
            @csrf
          <div class="cart-item border-bottom padding-small">
            <div class="row align-items-center">
              <div class="col-lg-4 col-md-3">
                <div class="cart-info d-flex gap-2 flex-wrap align-items-center">
                  <div class="col-lg-5">
                    <div class="card-image">
                      @if ($item->product && $item->product->images->isNotEmpty())
                      <img src="{{ Storage::url($item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="img-fluid border rounded-3">
                      @endif
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card-detail">
                      <h5 class="mt-2"><a href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a></h5>
                      <div class="card-price">
                        <span class="price text-primary fw-light">{{ number_format($item->price) }} <strong>VND</strong></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-7">
                <div class="row d-flex">
                  <div class="col-md-6">
                    <div class="product-quantity my-2 my-2">
                      <div class="input-group product-qty align-items-center" style="max-width: 150px;">
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-left-minus" data-type="minus" data-field="">
                            <svg width="16" height="16">
                              <use xlink:href="#minus"></use>
                            </svg>
                          </button>
                        </span>
                       
                        <input type="text" id="quantity" name="quantity" class="form-control bg-white shadow border rounded-3 py-2 mx-2 input-number text-center" value="{{ $item->quantity }}" min="1" max="100" required="">
                        
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-right-plus" data-type="plus" data-field="">
                            <svg width="16" height="16">
                              <use xlink:href="#plus"></use>
                            </svg>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="total-price">
                      <span class="money fs-2 fw-light text-primary">{{ number_format($item->price * $item->quantity) }}<strong>VND</strong></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-2">
                <div class="cart-cross-outline">
                  <div class="d-flex align-items-center gap-2">
                   <!-- nút cập nhật -->
                   <button type="submit" class="btn p-0" title="Cập nhật" style="border:none; background:none;">
                     <svg width="38" height="38"><use xlink:href="#icon-refresh"></use></svg>
                  </button>
                  <form action="{{ route('cart.remove', $item->product_id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                    @csrf
                  <button type="submit" style="border: none; background: none;">
                    <svg class="cart-cross-outline" width="38" height="38">
                      <use xlink:href="#cart-cross-outline"></use>
                    </svg>
                    
                  </button>
                </form>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </form>
          @endforeach


              

            </div>
          </div>
        </div>
        <div class="cart-totals padding-medium pb-0">
          <h3 class="mb-3">Tổng số giỏ hàng</h3>
          <div class="total-price pb-3">
            <table cellspacing="0" class="table text-capitalize">
              <tbody>
                <tr class="subtotal pt-2 pb-2 border-top border-bottom">
                  <th>Tổng giá</th>
                  <td data-title="Subtotal">
                    <span class="price-amount amount text-primary ps-5 fw-light">
                      <bdi>
                        {{ number_format($total) }}
                        <span class="price-currency-symbol">VND</span>
                      </bdi>
                    </span>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>
          <div class="button-wrap d-flex flex-wrap gap-3">

            <a href="{{ route('shop') }}" class="btn">Tiếp tục mua sắm</a>
            <a href="{{ route('checkout') }}" class="btn">Tiến hành thanh toán</a>
          </div>
        </div>
      </div>
    </div>

    @endif



@endsection
