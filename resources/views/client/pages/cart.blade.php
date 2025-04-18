<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

  <section class="hero-section position-relative padding-large"
    style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
    <div class="container">
      <div class="row">
      <div class="text-center">
        <h1>Cart</h1>
        <div class="breadcrumbs">
        <span class="item">
          <a href="index.html">Home &gt; </a>
        </span>
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
      <img src="{{ Storage::url($item->product->images->first()->image_path) }}"
      alt="{{ $item->product->name }}" class="img-fluid border rounded-3">
    @endif
      </div>
      </div>
      <div class="col-lg-4">
      <div class="card-detail">
        <h5 class="mt-2"><a
        href="{{ route('product.show', $item->product->id) }}">{{ $item->product->name }}</a></h5>
        <div class="card-price">
        <span class="price text-primary fw-light">{{ number_format($item->price) }}
        <strong>VND</strong></span>
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
        <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-left-minus"
        data-type="minus" data-field="">
        <svg width="16" height="16">
        <use xlink:href="#minus"></use>
        </svg>
        </button>
        </span>

        <input type="text" id="quantity" name="quantity"
        class="form-control bg-white shadow border rounded-3 py-2 mx-2 input-number text-center"
        value="{{ $item->quantity }}" min="1" max="100" required="">

        <span class="input-group-btn">
        <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-right-plus"
        data-type="plus" data-field="">
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
        <span
        class="money fs-2 fw-light text-primary">{{ number_format($item->price * $item->quantity) }}<strong>VND</strong></span>
      </div>
      </div>
      </div>
      </div>
      <div class="col-lg-1 col-md-2">
      <div class="cart-cross-outline">
      <div class="d-flex align-items-center gap-2">
      <!-- nút cập nhật -->
      <button type="submit" class="btn p-0" title="Cập nhật" style="border:none; background:none;">
        <svg width="38" height="38">
        <use xlink:href="#icon-refresh"></use>
        </svg>
      </button>
      <form action="{{ route('cart.remove', $item->product_id) }}" method="POST"
        onsubmit="return confirm('Remove this item?')">
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



    <section id="latest-posts" class="padding-large">
    <div class="container">
      <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
      <h3 class="d-flex align-items-center">Bài viết mới nhất</h3>
      <a href="shop.html" class="btn">Xem tất cả</a>

      </div>
      <div class="row">
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item1.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">10 cuốn sách nhất định phải
          đọc trong năm: Lựa chọn hàng đầu của chúng tôi!</a></h4>
        <p class="mb-2">Khám phá thế giới công nghệ tiên tiến với bài đăng trên blog mới nhất của chúng tôi, nơi chúng
        tôi nêu bật
        năm tiện ích thiết yếu. <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc
          thêm</a></span>

        </p>
      </div>
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item2.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Thế giới hấp dẫn của khoa học
          viễn tưởng</a></h4>
        <p class="mb-2">Khám phá sự giao thoa giữa công nghệ và tính bền vững trong bài đăng blog mới nhất của chúng
        tôi. Tìm hiểu về <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc
          thêm</a></span> </p>
      </div>
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item3.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Tìm thấy tình yêu trong những
          trang sách</a></h4>
        <p class="mb-2">Hãy đón đầu xu hướng với góc nhìn sâu sắc của chúng tôi về bối cảnh phát triển nhanh chóng của
        công nghệ đeo được. <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc
          thêm</a></span>
        </p>
      </div>
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item4.jpg" alt="post image" class="img-fluid rounded-3">

        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Đọc sách để có sức khỏe tinh
          thần: Sách có thể chữa lành và truyền cảm hứng như thế nào</a></h4>
        <p class="mb-2">Trong môi trường làm việc từ xa ngày nay, năng suất là chìa khóa. Khám phá các ứng dụng và
        công cụ hàng đầu
        có thể giúp bạn duy trì <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc
          thêm</a></span>

        </p>
      </div>
      </div>
    </div>
    </section>

    <section id="instagram">
    <div class="container">
      <div class="text-center mb-4">
      <h3>Instagram</h3>
      </div>
      <div class="row">
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
        <a href="https://templatesjungle.com/" class="image-link position-relative">
          <div class="icon-overlay position-absolute d-flex justify-content-center">
          <svg class="instagram">
            <use xlink:href="#instagram"></use>
          </svg>
          </div>
          <img src="assetClient/images/insta-item1.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
        </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
        <a href="https://templatesjungle.com/" class="image-link position-relative">
          <div class="icon-overlay position-absolute d-flex justify-content-center">
          <svg class="instagram">
            <use xlink:href="#instagram"></use>
          </svg>
          </div>
          <img src="assetClient/images/insta-item2.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
        </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
        <a href="https://templatesjungle.com/" class="image-link position-relative">
          <div class="icon-overlay position-absolute d-flex justify-content-center">
          <svg class="instagram">
            <use xlink:href="#instagram"></use>
          </svg>
          </div>
          <img src="assetClient/images/insta-item3.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
        </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
        <a href="https://templatesjungle.com/" class="image-link position-relative">
          <div class="icon-overlay position-absolute d-flex justify-content-center">
          <svg class="instagram">
            <use xlink:href="#instagram"></use>
          </svg>
          </div>
          <img src="assetClient/images/insta-item4.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
        </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
        <a href="https://templatesjungle.com/" class="image-link position-relative">
          <div class="icon-overlay position-absolute d-flex justify-content-center">
          <svg class="instagram">
            <use xlink:href="#instagram"></use>
          </svg>
          </div>
          <img src="assetClient/images/insta-item5.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
        </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
        <a href="https://templatesjungle.com/" class="image-link position-relative">
          <div class="icon-overlay position-absolute d-flex justify-content-center">
          <svg class="instagram">
            <use xlink:href="#instagram"></use>
          </svg>
          </div>
          <img src="assetClient/images/insta-item6.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
        </a>
        </figure>
      </div>
      </div>
    </div>
    </section>


  @endsection