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
                                    <li class="breadcrumb-item"><a href="{{ route('index') }}"><i
                                                class="fa fa-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Cửa hàng</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sản phẩm yêu thích</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->

        <!-- wishlist main wrapper start -->
        <div class="wishlist-main-wrapper section-padding">
            <div class="container">
                <!-- Wishlist Page Content Start -->
                <div class="section-bg-color">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Wishlist Table Area -->
                            <div class="cart-table table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="pro-thumbnail">Thumbnail</th>
                                            <th class="pro-title">Product</th>
                                            <th class="pro-price">Price</th>
                                            <th class="pro-quantity">Số lượng sản phẩm</th>
                                            <th class="pro-subtotal">Add to Cart</th>
                                            <th class="pro-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($wishlistItems as $item)
                                            <tr>
                                                <td class="pro-thumbnail">
                                                    <a href="{{ route('product.show', $item->product->id) }}">
                                                        <img class="img-fluid"
                                                            src="{{ $item->product->thumbnail ? Storage::url($item->product->thumbnail->image_path) : asset('assets/img/default.jpg') }}"
                                                            alt="{{ $item->product->name }}">

                                                    </a>
                                                </td>
                                                <td class="pro-title">
                                                    <a href="{{ route('product.show', $item->product->id) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </td>
                                                <td class="pro-price"><span>{{ number_format($item->product->price) }} đ</span>
                                                </td>
                                                <td class="pro-quantity">
                                                    @if ($item->product->quantity > 0)
                                                        <span class="text-success">Còn hàng</span>
                                                    @else
                                                        <span class="text-danger">Không còn hàng</span>
                                                    @endif
                                                </td>
                                                <td class="pro-subtotal">
                                                    @if ($item->product->quantity > 0)
                                                        <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-sqr" type="submit">Thêm vào giỏ hàng</button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-sqr disabled" disabled>Sản phẩm hết hàng</button>
                                                    @endif
                                                </td>

                                                <td class="pro-remove">
                                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link text-danger"><i
                                                                class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Chưa có sản phẩm yêu thích nào.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Wishlist Page Content End -->
            </div>
        </div>
        <!-- wishlist main wrapper end -->
    </main>

@endsection