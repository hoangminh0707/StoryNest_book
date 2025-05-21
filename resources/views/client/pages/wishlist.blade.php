@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('active_pages_shop', 'active')

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
                                <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
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
            <!-- Bắt đầu nội dung trang Danh sách yêu thích -->
            <div class="section-bg-color">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Khu vực bảng Danh sách yêu thích -->
                        <div class="cart-table table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Hình ảnh</th>
                                        <th class="pro-title">Sản phẩm</th>
                                        <th class="pro-price">Giá</th>
                                        <th class="pro-quantity">Tình trạng</th>
                                        <th class="pro-subtotal">Thêm vào giỏ</th>
                                        <th class="pro-remove">Xóa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($wishlistItems as $item)
                                    <tr>
                                        <td class="pro-thumbnail">
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                @php
                                                $firstImage = $item->product->images->first();
                                                @endphp
                                                @if ($firstImage)
                                                <img class="img-fluid" src="{{ Storage::url($firstImage->image_path) }}" alt="{{ $item->product->name }}">
                                                @else
                                                <img class="img-fluid" src="{{ asset('assets/img/default-product.jpg') }}" alt="No image">
                                                @endif
                                            </a>
                                        </td>

                                        <td class="pro-title">
                                            <a href="{{ route('product.show', $item->product->slug) }}">
                                                {{ $item->product->name }}
                                            </a>
                                        </td>
                                        <td class="pro-price">
                                            <div class="price-box">
                                                @php
                                                // Lấy sản phẩm và các biến thể của sản phẩm
                                                $product = $item->product;
                                                $variants = $product->variants;
                                                $variantCount = $variants->count();

                                                // Khởi tạo giá trị mặc định
                                                $minPrice = 0;
                                                $maxPrice = 0;

                                                // Nếu có biến thể, lấy giá min và max
                                                if ($variantCount === 1) {
                                                // Nếu có một biến thể, lấy giá của biến thể
                                                $minPrice = (float)$variants->first()->variant_price;
                                                } elseif ($variantCount > 1) {
                                                // Nếu có nhiều biến thể, lấy giá min và max
                                                $minPrice = (float)$variants->min('variant_price');
                                                $maxPrice = (float)$variants->max('variant_price');
                                                } else {
                                                // Nếu không có biến thể, lấy giá mặc định của sản phẩm
                                                $minPrice = (float)$product->price;
                                                }
                                                @endphp

                                                @if ($variantCount === 1)
                                                <span id="variant-price" class="price-regular">{{ number_format($minPrice, 0, ',', '.') }} đ</span>
                                                @elseif ($variantCount > 1)
                                                <span id="variant-price" class="price-regular">
                                                    {{ number_format($minPrice, 0, ',', '.') }} đ - {{ number_format($maxPrice, 0, ',', '.') }} đ
                                                </span>
                                                @else
                                                <span id="variant-price" class="price-regular">{{ number_format($minPrice, 0, ',', '.') }} đ</span>
                                                @endif
                                            </div>

                                        </td>
                                        <td class="pro-quantity">
                                            @php
                                            $isInStock = false;
                                            if ($item->product->product_type === 'variable') {
                                            $isInStock = $item->product->variants->sum('stock_quantity') > 0;
                                            } else {
                                            $isInStock = $item->product->quantity > 0;
                                            }
                                            @endphp

                                            @if ($isInStock)
                                            <span class="text-success">Còn hàng</span>
                                            @else
                                            <span class="text-danger">Hết hàng</span>
                                            @endif
                                        </td>

                                        <td class="pro-subtotal">
                                            @if ($isInStock)
                                                @if ($item->product->product_type === 'variable')
                                                    <a href="{{ route('product.show', $item->product->slug) }}" class="btn btn-sqr">Chọn biến thể</a>
                                                @else
                                                    <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="from_wishlist" value="1">
                                                        <button type="submit" class="btn btn-sqr">Thêm vào giỏ</button>
                                                    </form>
                                                @endif
                                            @else
                                                <button class="btn btn-sqr disabled" disabled>Hết hàng</button>
                                            @endif
                                        </td>




                                        <td class="pro-remove">
                                            <form action="{{ route('wishlist.remove', $item->product->slug) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi yêu thích?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sqr "><i class="fa fa-trash-o"></i> Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Danh sách yêu thích của bạn đang trống.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Kết thúc nội dung trang Danh sách yêu thích -->
        </div>
    </div>
    <!-- wishlist main wrapper end -->
</main>

@endsection