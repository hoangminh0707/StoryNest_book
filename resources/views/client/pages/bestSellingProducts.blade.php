<section class="related-products section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12"> <!-- section title start -->
                <div class="section-title text-center">
                    <h2 class="title">Sản Phẩm Bán Chạy</h2>
                    <p class="sub-title">Những sản phẩm được yêu thích nhất hiện nay</p>
                </div> <!-- section title end -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-carousel-4 slick-row-10 slick-arrow-style"> @foreach ($bestSellingProducts as $product) @php $thumbnail = $product->images->where('is_thumbnail', true)->first(); $secondary = $product->images->where('is_thumbnail', false)->first(); $variants = $product->variants; $minPrice = $variants->min('variant_price'); $maxPrice = $variants->max('variant_price'); @endphp
                    <div class="product-item">
                        <figure class="product-thumb">
                            <a href="{{ route('product.show', $product->slug) }}">
                                @if ($thumbnail)
                                <img class="pri-img" src="{{ Storage::url($thumbnail->image_path) }}" alt="product">
                                @endif
                                @if ($secondary)
                                <img class="sec-img" src="{{ Storage::url($secondary->image_path) }}" alt="product">
                                @endif
                            </a>
                            <div class="product-badge">
                                <div class="product-label new"><span>bán chạy</span></div>
                            </div>
                            <div class="button-group">
                                <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip" title="Yêu thích">
                                    <i class="pe-7s-like"></i>
                                </a>
                            </div>
                            <div class="cart-hover">
                                @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-cart">Thêm vào giỏ</button>
                                </form>
                                @endauth

                                @guest
                                <button onclick="showLoginAlert()" class="btn btn-cart">Thêm vào giỏ</button>
                                @endguest
                            </div>
                        </figure>

                        <div class="product-caption text-center">
                            <p class="manufacturer-name">
                                <a href="#">{{ $product->author->name ?? 'Không rõ tác giả' }}</a>
                            </p>
                            <h6 class="product-name">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h6>
                            <div class="price-box">
                                @if ($variants->count() === 1)
                                <span class="price-regular">{{ number_format($minPrice) }} đ</span>
                                @elseif ($variants->count() > 1)
                                <span class="price-regular">{{ number_format($minPrice) }} đ - {{ number_format($maxPrice) }} đ</span>
                                @else
                                <span class="price-regular">{{ number_format($product->price) }} đ</span>
                                @endif
                            </div>
                            <div class="mt-1">
                                <small>Đã bán: {{ $product->total_sold ?? 0 }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>