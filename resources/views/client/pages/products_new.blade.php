<section class="product-area section-padding">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- Tiêu đề phần bắt đầu -->
        <div class="section-title text-center">
          <h2 class="title">Sản phẩm mới</h2>
          <p class="sub-title">Thêm sản phẩm của chúng tôi vào danh sách hàng tuần của bạn</p>
        </div>
        <!-- Tiêu đề phần kết thúc -->
      </div>
    </div>
    <<div class="row">
      <div class="col-12">
        <div class="product-carousel-4 slick-row-10 slick-arrow-style">
          @forelse ($newestProducts as $product)
          @php
        $thumbnail = $product->images->where('is_thumbnail', true)->first();
        $otherImage = $product->images->where('is_thumbnail', false)->first();
        @endphp
          <div class="product-item">
          <figure class="product-thumb">
            <a href="{{ route('product.show', $product->slug) }}">
            @if ($thumbnail)
          <img class="pri-img" src="{{ Storage::url($thumbnail->image_path) }}" alt="product">
        @endif
            @if ($otherImage)
          <img class="sec-img" src="{{ Storage::url($otherImage->image_path) }}" alt="product">
        @endif
            </a>
            <div class="product-badge">
            <div class="product-label new"><span>Mới</span></div>
            @if($product->discount_percentage)
          <div class="product-label discount"><span>{{ $product->discount_percentage }}%</span></div>
        @endif
            </div>
            <div class="button-group">
            @auth
          <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip" data-bs-placement="left"
          title="Thêm vào danh sách yêu thích"><i class="pe-7s-like"></i></a>
        @endauth
            @guest
          <a href="#" onclick="showLoginAlert()" data-bs-toggle="tooltip" data-bs-placement="left"
          title="Thêm vào danh sách yêu thích"><i class="pe-7s-like"></i></a>
        @endguest
            <a href="#" class="btn-quick-view" data-name="{{ $product->name }}"
              data-price="{{ number_format($product->price) }}" data-description="{{ $product->description }}"
              data-stock="{{ $product->quantity }}" data-author="{{ $product->author->name ?? 'Không rõ' }}"
              data-images='@json($product->images->pluck("image_path"))' data-bs-toggle="modal"
              data-bs-target="#quick_view">
              <span data-bs-toggle="tooltip" data-bs-placement="left" title="Xem nhanh">
              <i class="pe-7s-search"></i>
              </span>
            </a>
            </div>
            <div class="cart-hover">
            @auth
          <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-cart">Thêm vào giỏ</button>
          </form>
        @endauth
            @guest
          <button onclick="showLoginAlert()" class="btn btn-cart">Thêm vào giỏ</button>
        @endguest
            </div>
          </figure>
          <div class="product-caption">
            <div class="product-identity">
            <p class="manufacturer-name">
              <a href="#">{{ $product->author->name ?? 'Không rõ' }}</a>
            </p>
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
          <span class="price-regular">{{ number_format($minPrice) }} đ - {{ number_format($maxPrice) }} đ</span>
        @else
          <span class="price-regular">{{ number_format($product->price) }} đ</span>
        @endif
            </div>
          </div>
          </div>
      @empty
        <p class="text-center">Không có sản phẩm mới nào.</p>
      @endforelse
        </div>
      </div>
  </div>

  </div>
  </div>
  </div>
  </div>
</section>