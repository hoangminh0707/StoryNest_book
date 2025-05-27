<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('active_pages_shop', 'active')

@section('content')

  <div class="breadcrumb-area">
    <div class="container">
    <div class="row">
      <div class="col-12">
      <div class="breadcrumb-wrap">
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
          <li class="breadcrumb-item active" aria-current="page">Cửa hàng</li>
        </ul>
        </nav>
      </div>
      </div>
    </div>
    </div>
  </div>


  <!-- page main wrapper start -->
  <div class="shop-main-wrapper section-padding">
    <div class="container">
    <div class="row">
      <!-- shop main wrapper start -->
      <div class="col-lg-12">
      <div class="shop-product-wrapper">
        <!-- shop product top wrap start -->
        <div class="shop-top-bar">
        <div class="row align-items-center">
          <div class="col-lg-7 col-md-6 order-2 order-md-1">
          <div class="top-bar-left">
            <div class="product-view-mode">
            <a href="#" data-target="grid-view" data-bs-toggle="tooltip" title="Grid View"><i
              class="fa fa-th"></i></a>
            <a class="active" href="#" data-target="list-view" data-bs-toggle="tooltip" title="List View"><i
              class="fa fa-list"></i></a>
            </div>
            <div class="product-amount">
            <p>Hiển thị từ {{ $products->firstItem() }}–{{ $products->lastItem() }} trong tổng
              {{ $products->total() }}
              sản phẩm
            </p>
            </div>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
      <!-- shop product top wrap start -->

      <!-- product item list wrapper start -->
      <div class="shop-product-wrap list-view row mbn-30">
      <!-- product single item start -->
      @foreach ($products as $product)
      <div class="col-lg-3 col-md-4 col-sm-6">
      <!-- product grid start -->
      <div class="product-item">
      <figure class="product-thumb">
        <a href="{{ route('product.show', $product->slug) }}">
        <img class="pri-img" src="{{ Storage::url($product->images->first()->image_path) }}" alt="product">
        <img class="sec-img" src="{{ Storage::url($product->images->first()->image_path) }}" alt="product">
        </a>
        <div class="product-badge">
        @if ($product->created_at->gt(\Carbon\Carbon::now()->subDays(7)))
      <div class="product-label new">
      <span>new</span>
      </div>
      @endif

        @if (in_array($product->id, $bestSellingProductIds))
      <div class="product-label discount" style="background-color: red; color: white;">
      <span>bán chạy</span>
      </div>
      @endif
        </div>
        <div class="button-group">
        <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip" data-bs-placement="left"
        title="Thêm vào yêu thích"><i class="pe-7s-like"></i></a>
        </div>
        <div class="cart-hover">
        @auth
      <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
      @csrf
      <button class="btn btn-cart">Thêm vào giỏ hàng</button>
      </form>
      @endauth
        @guest
      <a href="onclick=" showLoginAlert()" class="btn btn-cart">Thêm vào giỏ hàng</a>
      @endguest
        </div>
      </figure>
      <div class="product-caption text-center">
        <div class="product-identity">
        <p class="manufacturer-name"><a
        href="{{ route('product.show', $product->slug) }}">{{ $product->author->name ?? " "}}</a></p>
        </div>

        <h6 class="product-name">
        <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
        </h6>
        @php
      $variants = $product->variants;
      if ($variants->count() > 0) {
      $minPrice = $variants->min('variant_price');
      $maxPrice = $variants->max('variant_price');
      }
      @endphp
        <div class="price-box">
        @if ($variants->count() === 1)
      <span class="price-regular">{{ number_format($minPrice) }} đ</span>
      @elseif ($variants->count() > 1)
      <span class="price-regular">{{ number_format($minPrice) }} đ -
      {{ number_format($maxPrice) }} đ </span>
      @else
      <span class="price-regular">{{ number_format($product->price) }}</span>
      @endif
        </div>
      </div>
      </div>
      <!-- product grid end -->

      <!-- product list item end -->
      <div class="product-list-item">
      <figure class="product-thumb">
        <a href="{{ route('product.show', $product->slug) }}">
        <img class="pri-img" src="{{ Storage::url($product->images->first()->image_path) }}" alt="product">
        <img class="sec-img" src="{{ Storage::url($product->images->first()->image_path) }}" alt="product">
        </a>
        <div class="product-badge">
        @if ($product->created_at->gt(\Carbon\Carbon::now()->subDays(7)))
      <div class="product-label new">
      <span>new</span>
      </div>
      @endif

        @if (in_array($product->id, $bestSellingProductIds))
      <div class="product-label discount" style="background-color: red; color: white;">
      <span>bán chạy</span>
      </div>
      @endif
        </div>


        <div class="button-group">
        <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip" data-bs-placement="left"
        title="Thêm vào yêu thích"><i class="pe-7s-like"></i></a>

        </div>
        <div class="cart-hover">
        @auth
      <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
      @csrf
      <button class="btn btn-cart" type="submit">Thêm vào giỏ hàng</button>
      </form>
      @endauth
        @guest
      <a href="onclick=" showLoginAlert()" class="btn btn-cart">Thêm vào giỏ hàng</a>
      @endguest
        </div>
      </figure>
      <div class="product-content-list">
        <div class="manufacturer-name">
        <a href="{{ route('product.show', $product->slug) }}">{{ $product->author->name}}</a>
        </div>


        <h5 class="product-name"><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
        </h5>
        <div class="price-box">
        @if ($variants->count() === 1)
      <span class="price-regular">{{ number_format($minPrice) }} đ</span>
      @elseif ($variants->count() > 1)
      <span class="price-regular">{{ number_format($minPrice) }} đ -
      {{ number_format($maxPrice) }} đ </span>
      @else
      <span class="price-regular">{{ number_format($product->price) }}</span>
      @endif
        </div>
        <p>{{ $product->description }}</p>
      </div>
      </div>
      <!-- product list item end -->
      </div>
      <!-- product single item start -->
    @endforeach
      </div>
    </div>
    </div>
    <!-- start pagination area -->
    <div class="paginatoin-area text-center mt-4">
    <ul class="pagination-box">
      @if ($products->onFirstPage())
      <li><a class="previous disabled"><i class="pe-7s-angle-left"></i></a></li>
    @else
      <li><a class="previous" href="{{ $products->previousPageUrl() }}"><i class="pe-7s-angle-left"></i></a></li>
    @endif

      @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
      <li class="{{ $products->currentPage() == $page ? 'active' : '' }}">
      <a href="{{ $url }}">{{ $page }}</a>
      </li>
    @endforeach

      @if ($products->hasMorePages())
      <li><a class="next" href="{{ $products->nextPageUrl() }}"><i class="pe-7s-angle-right"></i></a></li>
    @else
      <li><a class="next disabled"><i class="pe-7s-angle-right"></i></a></li>
    @endif
    </ul>
    </div>
    <!-- end pagination area -->
  </div>
  @include('client.pages.contact')







@endsection