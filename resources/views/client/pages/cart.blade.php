<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

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
          <li class="breadcrumb-item active" aria-current="page">cart</li>
          </ul>
        </nav>
        </div>
      </div>
      </div>
    </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- cart main wrapper start -->
    <div class="cart-main-wrapper section-padding">
    <div class="container">
      <div class="section-bg-color">
      <div class="row">
        <div class="col-lg-12">
        <!-- Cart Table Area -->
        <div class="cart-table table-responsive">
          <table class="table table-bordered">
          @if($cartItems->isEmpty())
        <div class="alert alert-warning">Giỏ hàng của bạn đang trống.</div>
      @else
          <thead>
          <tr>
          <th class="pro-thumbnail">Ảnh sản phẩm</th>
          <th class="pro-title">Tên sản phẩm</th>
          <th class="pro-price">Giá</th>
          <th class="pro-quantity">Số lượng</th>
          <th class="pro-subtotal">Tỏng tiền</th>
          <th class="pro-remove">Xóa</th>
          </tr>
          </thead>
          <tbody>
          @foreach ($cartItems as $item)

          <tr>
          <td class="pro-thumbnail"><a href="{{ route('product.show', $item->product->slug) }}">
          @if ($item->product && $item->product->images->isNotEmpty())
        <img class="img-fluid" src="{{ Storage::url($item->product->images->first()->image_path) }}"
        alt="{{ $item->product->name }}" />
        @endif
          </a></td>
          <td class="pro-title">
          <a href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a>
          <br>
          @if ($item->variant && $item->variant->attributeValues->isNotEmpty())
          @foreach ($item->variant->attributeValues as $attributeValue)
        <span class="cart-variran">Loại : {{ $attributeValue->value }} </span>
        @endforeach
        @else
        <span class="cart-variran">
        Loại : Mặc Định
        </span>
        @endif
          </td>
          <td class="pro-price"><span>{{ number_format($item->price) }} đ</span></td>
          <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
          @csrf
          <td class="pro-quantity">
          <div class="pro-qty"><input type="text" name="quantity" value="{{ $item->quantity }}"></div>
          </td>
          </form>
          <td class="pro-subtotal"><span>{{ number_format($item->price * $item->quantity) }} đ</span></td>

          <form action="{{ route('cart.remove', $item->product_id) }}" method="POST"
          onsubmit="return confirm('Remove this item?')">
          @csrf
          <td class="pro-remove"><button type="submit" style="border: none; background: none;"><i
          class="fa fa-trash-o"></i></button></td>
          </tr>
          </form>
        @endforeach
          </tbody>
      @endif
          </table>
        </div>

        <div class="row">
          <div class="col-lg-5 ml-auto">
          <!-- Cart Calculation Area -->
          <div class="cart-calculator-wrapper">
            <div class="cart-calculate-items">
            <h6>Cart Totals</h6>
            <div class="table-responsive">
              <table class="table">
              <tr>
                <td>Giá tổng tất cả sản phẩm</td>
                <td>{{ number_format($total) }}</td>
              </tr>
              <tr>
                <td>Phí ship</td>
                <td>Chưa tính</td>
              </tr>
              <tr class="total">
                <td>Tổng</td>
                <td class="total-amount">{{ number_format($total) }}</td>
              </tr>
              </table>
            </div>
            </div>
            <a href="{{ route('checkout') }}" class="btn btn-sqr d-block">Tiến hành thanh toán</a>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
      <!-- cart main wrapper end -->
  </main>

@endsection