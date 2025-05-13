<?php
?>

@extends('client.layouts.app')

@section('content')


  <style>
    .quantity-input .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
    }

    /* Voucher tốt nhất ngoài trang */
    .best-voucher {
    border: 1px solid #d1e7dd;
    background-color: #f0fdf4;
    padding: 16px;
    border-radius: 12px;
    margin-top: 20px;
    position: relative;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .best-voucher .badge {
    font-size: 14px;
    background-color: #28a745;
    color: white;
    padding: 6px 10px;
    border-radius: 8px;
    margin-bottom: 8px;
    display: inline-block;
    }

    .best-voucher p {
    margin: 5px 0;
    font-weight: bold;
    color: #1a1a1a;
    }

    /* Modal voucher */
    .voucher-item {
    background-color: #f8f9fa;
    border-left: 5px solid #0d6efd;
    padding: 12px;
    border-radius: 6px;
    transition: all 0.2s ease-in-out;
    }

    .voucher-item:hover {
    background-color: #e9f3ff;
    transform: scale(1.01);
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
          <li class="breadcrumb-item"><a href="{{ route('index') }}"><i class="fa fa-home"></i></a></li>
          <li class="breadcrumb-item"><a href="{{ route('shop') }}">Cửa hàng</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $product->name}}</li>
          </ul>
        </nav>

        </div>
      </div>
      </div>
    </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding pb-0">
    <div class="container">
      <div class="row">
      <!-- product details wrapper start -->
      <div class="col-lg-12 order-1 order-lg-2">
        <!-- product details inner end -->
        <div class="product-details-inner">
        <div class="row">
          <div class="col-lg-5">
          <div class="product-large-slider">
            @if($thumbnail)
        <div class="pro-large-img img-zoom">
        <img src="{{ Storage::url($thumbnail->image_path) }}" alt="product-details">
        </div>
        @endif

            @foreach($otherImages as $index => $image)
        <div class="pro-large-img img-zoom">
        <img src="{{ Storage::url($image->image_path)}}" alt="product-details">
        </div>
        @endforeach
          </div>

          <div class="pro-nav slick-row-10 slick-arrow-style">
            @if($thumbnail)
        <div class="pro-nav-thumb">
        <img src="{{ Storage::url($thumbnail->image_path) }}" alt="product-details">
        </div>
        @endif

            @foreach($otherImages as $index => $image)
        <div class="pro-nav-thumb">
        <img src="{{ Storage::url($image->image_path)}}" alt="product-details">
        </div>
        @endforeach
          </div>
          </div>

          <div class="col-lg-7">
          <div class="product-details-des">
            <div class="manufacturer-name">
            <a>{{ $product->author->name }}</a>
            </div>
            <h3 class="product-name">{{ $product->name }}</h3>
          </div>
          @if ($averageRating)
          <div class="ratings d-flex">
          @for ($i = 1; $i <= 5; $i++)
          @if ($i <= floor($averageRating))
        <i class="fa fa-star" style="color: gold;"></i>
        @elseif ($i - $averageRating < 1)
        <i class="fa fa-star-half-o" style="color: gold;"></i>
        @else
        <i class="fa fa-star-o" style="color: gold;"></i>
        @endif
        @endfor
          <div class="pro-review">
          <span>({{ number_format($averageRating, 1) }} / 5)</span>
          </div>
          </div>
      @endif
          @php
        $variants = $product->variants;
        if ($variants->count() > 0) {
        $minPrice = $variants->min('variant_price');
        $maxPrice = $variants->max('variant_price');
        }
        $totalStock = $variants->sum('stock_quantity');
        @endphp
          <div class="price-box">
            @if ($variants->count() === 1)
        <span id="variant-price" class="price-regular">{{ number_format($minPrice) }} đ</span>
        @elseif ($variants->count() > 1)
        <span id="variant-price" class="price-regular">
        {{ number_format($minPrice) }} đ - {{ number_format($maxPrice) }} đ
        </span>
        @else
        <span id="variant-price" class="price-regular">{{ number_format($product->price) }} đ</span>
        @endif
          </div>
          <div class="product-voucher">
            <ul class="voucher-list">
            @if ($bestVoucher)
          <div
            class="alert alert-success d-flex justify-content-between align-items-center p-3 rounded shadow-sm mt-3">
            <div>
            <strong>🎁 Ưu đãi tốt nhất: </strong>
            <span class="text-primary">{{ $bestVoucher->code }}</span> -
            @if ($bestVoucher->type === 'percent')
          Giảm {{ number_format($bestVoucher->value) }}%
          @if ($bestVoucher->max_discount_amount)
          (Tối đa {{ number_format($bestVoucher->max_discount_amount) }}₫)
          @endif
        @else
          Giảm {{ number_format($bestVoucher->value) }}₫
        @endif
            </div>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#voucherModal">
            Xem thêm ưu đãi
            </button>
          </div>
        @endif
            </ul>
          </div>
          @if ($product->status !== 'discontinued')
          <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST"
          style="display:inline;">
          @csrf
          <input type="hidden" name="price" id="product_price">
          <input type="hidden" name="product_variant_id" id="product_variant_id">

          <div class="availability">
          <i class="fa fa-check-circle"></i>
          <span id="stock-info">
            Số Lượng :
            @if ($product->product_type === 'variable')
          {{ $variants->sum('stock_quantity') }}
        @else
          {{ $product->quantity }}
        @endif
          </span>
          </div>

          <p class="pro-desc">{{ $product->description }}</p>

          <div class="quantity-cart-box d-flex align-items-center gap-2">
          <h6 class="option-title mb-0">SL:</h6>
          <div class="input-group quantity-input" style="width: 120px;">
            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQty(-1)">-</button>
            <input type="number" name="quantity" class="form-control text-center" value="1" min="1">
            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQty(1)">+</button>
          </div>

          @php
          $isAvailable = $product->product_type === 'variable'
          ? $variants->sum('stock_quantity') > 0
          : $product->quantity > 0;
        @endphp

          <div class="action_link">
            @if ($isAvailable)
          <button type="submit" class="btn btn-cart2" id="add-to-cart-btn">Thêm vào giỏ hàng</button>
        @else
          <button class="btn btn-cart2" id="add-to-cart-btn" disabled>Sản phẩm đã hết hàng</button>
        @endif
          </div>
          </div>

          @foreach ($groupedAttributes as $attributeName => $attributeValues)
          <div class="pro-size">
          <h6 class="option-title">{{ $attributeName }} </h6>
          <select name="variant_id" id="{{ strtolower($attributeName) }}_variant_id" class="form-control"
          style="width: 100%; max-width: 120px;">
          <option value="">Chọn {{ $attributeName }}</option>
          @foreach ($attributeValues as $attribute)
        <option value="{{ $attribute['variant_id'] }}" data-price="{{ $attribute['price']}}"
        data-stock="{{ $attribute['stock_quantity'] }}">
        {{ $attribute['value'] }}
        </option>
        @endforeach
          </select>
          </div>
        @endforeach
          </form>
      @else
        <div class="alert alert-warning mt-3">
        <strong>Lưu ý:</strong> Sản phẩm này hiện đã <strong>ngừng kinh doanh</strong> và không thể mua.
        </div>
      @endif


          <div class="useful-links">
            <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip" title="Wishlist">
            <i class="pe-7s-like"></i> wishlist
            </a>
          </div>
          </div>
        </div>
        </div>



        <!-- product details inner end -->

        <!-- product details reviews start -->
        <div class="product-details-reviews section-padding pb-0">
        <div class="row">
          <div class="col-lg-12">
          <div class="product-review-info">
            <ul class="nav review-tab">
            <li>
              <a class="active" data-bs-toggle="tab" href="#tab_one">Mô tả</a>
            </li>
            <li>
              <a data-bs-toggle="tab" href="#tab_two">Thông tin</a>
            </li>
            <li>
              <a data-bs-toggle="tab" href="#tab_three">Đánh giá
              ({{ $product->reviews->where('is_approved', true)->count() }})</a>
            </li>
            </ul>
            <div class="tab-content reviews-tab">
            <div class="tab-pane fade show active" id="tab_one">
              <div class="tab-one">
              <p>{{ $product->description}}</p>
              </div>
            </div>
            <div class="tab-pane fade" id="tab_two">
              <table class="table table-bordered">
              <tbody>
                @foreach ($groupedAttributes as $attributeName => $attributeValues)
            <tr>
            <td>{{ $attributeName }}</td>
            <td>
              @foreach ($attributeValues as $attribute)
          {{ $attribute['value'] }}
          @endforeach
            </td>
            </tr>
          @endforeach
              </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="tab_three">
              @if ($product->reviews->where('is_approved', true)->count())
            <div class="review-form">
            <h5>{{ $product->reviews->where('is_approved', true)->count() }} đánh giá cho
            <span>{{ $product->name }}</span>
            </h5>

            @foreach ($product->reviews->where('is_approved', true) as $review)
          <div class="total-reviews">
          <div class="rev-avatar">
          <img
            src="{{ asset($review->user->avatar ?? 'https://i.ibb.co/WpKLtySw/Logo-Story-Nest-Book.jpg') }}"
            alt="User Avatar">
          </div>

          <div class="review-box">
          <div class="ratings">
            @for ($i = 1; $i <= 5; $i++)
          @if ($i <= $review->rating)
          <span class="good"><i class="fa fa-star"></i></span>
          @else
          <span><i class="fa fa-star"></i></span>
          @endif
          @endfor
          </div>

          <div class="post-author">
            <p>
            <span>{{ $review->user->name ?? 'Ẩn danh' }} -</span>
            {{ \Carbon\Carbon::parse($review->created_at)->format('d M, Y') }}
            </p>
          </div>

          <p>{{ $review->comment }}</p>
          </div>
          </div>
        @endforeach
            </div>
        @else
          <p>Chưa có đánh giá nào cho sản phẩm này.</p>
        @endif

              @if ($canReview)
            <div class="form-group row">
            <div class="col">
            <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <label class="col-form-label"><span class="text-danger">*</span>
              Đánh giá của bạn</label>
            <textarea name="comment" class="form-control" required></textarea>
            </div>
            </div>
            <div class="form-group row">
            <div class="col">
            <label class="col-form-label"><span class="text-danger">*</span>
            Đánh giá</label>
            @for ($i = 5; $i >= 1; $i--)
          <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
          <label for="star{{ $i }}" style="margin-right: 10px;">{{ $i }} ⭐</label>
          @endfor
            </div>

            </div>
            <div class="buttons">
            <button class="btn btn-sqr" type="submit">Đánh giá sản phẩm</button>
            </form>
            </div>
          </div> <!-- end of review-form -->
        @else
        <p class="text-muted">Bạn cần mua sản phẩm này trước khi có thể đánh giá.</p>
        @endif
            </div>
          </div>
          </div>
        </div>
        </div>
      </div>
      <!-- product details reviews end -->
      </div>
      <!-- product details wrapper end -->
    </div>
    </div>
    </div>
    <!-- page main wrapper end -->

    <!-- related products area start -->
    <section class="related-products section-padding">
    <div class="container">
      <div class="row">
      <div class="col-12">
        <!-- section title start -->
        <div class="section-title text-center">
        <h2 class="title">Related Products</h2>
        <p class="sub-title">Add related products to weekly lineup</p>
        </div>
        <!-- section title start -->
      </div>
      </div>
      <div class="row">
      <div class="col-12">
        <div class="product-carousel-4 slick-row-10 slick-arrow-style">
        <!-- product item start -->

        @foreach ($products as $product)

        @php
        $thumbnail = $product->images->where('is_thumbnail', true)->first();
        $secondary = $product->images->where('is_thumbnail', false)->first();
        @endphp
        <div class="product-item">
          <figure class="product-thumb">
          <a href="{{ route('product.show', $product->slug) }}">

          <img class="pri-img" src="{{ storage::url($thumbnail->image_path) }}" alt="product">
          <img class="sec-img" src="{{ storage::url($secondary->image_path) }}" alt="product">
          </a>
          <div class="product-badge">
          <div class="product-label new">
          <span>new</span>
          </div>
          </div>
          <div class="button-group">
          <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip" data-bs-placement="left"
          title="Add to wishlist"><i class="pe-7s-like"></i></a>

          </span>
          </a>
          </div>
          <div class="cart-hover">
          @auth
        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-cart">add to cart</button>
        </form>
        @endauth

          @guest
        <button onclick="showLoginAlert()" class="btn btn-cart">add to cart</button>
        @endguest
          </div>
          </figure>

          <div class="product-caption text-center">
          <div class="product-identity">
          <p class="manufacturer-name">
          <a href="#">{{ $product->author->name ?? 'Không rõ tác giả' }}</a>
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
        <span class="price-regular">{{ number_format($minPrice) }} đ -
        {{ number_format($maxPrice) }} đ </span>
        @else
        <span class="price-regular">{{ number_format($product->price) }}</span>
        @endif
          </div>

          </div>
        </div>
      @endforeach



        </div>
      </div>
      </div>
    </div>
    </section>
    <!-- related products area end -->
  </main>


  <!-- Modal: Tất cả ưu đãi áp dụng -->
  <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="voucherModalLabel">Tất cả ưu đãi áp dụng</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
      @forelse($vouchers as $voucher)
      <div class="voucher-item p-3 mb-3 rounded shadow-sm border bg-light">
        <div class="d-flex justify-content-between align-items-center">
        <div>
        <strong>{{ $voucher->code }}</strong> -
        @if ($voucher->type === 'percent')
        {{ number_format($voucher->value) }}%
        @if ($voucher->max_discount_amount)
        (Tối đa {{ number_format($voucher->max_discount_amount) }}₫)
      @endif
      @else
        {{ number_format($voucher->value) }}₫
      @endif
        </div>
        <div class="text-muted small">
        HSD:
        {{ $voucher->expires_at ? \Carbon\Carbon::parse($voucher->expires_at)->format('d/m/Y') : 'Không giới hạn' }}
        </div>
        </div>

        @if ($voucher->min_order_value)
      <div class="mt-1 small text-secondary">
      Đơn tối thiểu: {{ number_format($voucher->min_order_value) }}₫
      </div>
      @endif
      </div>
    @empty
      <p>Không có voucher áp dụng.</p>
    @endforelse
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
    </div>
  </div>




        @if ($voucher->min_order_value)
      <div class="mt-1 small text-secondary">
      Đơn tối thiểu: {{ number_format($voucher->min_order_value) }}₫
      </div>
      @endif
      </div>
    @empty
      <p>Không có voucher áp dụng.</p>
    @endforelse
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
    </div>
  </div>





  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const selects = document.querySelectorAll('select[name="variant_id"]');
    const stockInfo = document.getElementById('stock-info');
    const priceBox = document.getElementById('variant-price');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    // 👉 Lưu giá ban đầu
    const defaultPriceText = priceBox ? priceBox.innerText : '';

    if (selects.length > 0) {
      selects.forEach(select => {
      select.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
        const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;

        // 👉 Nếu người dùng chưa chọn gì
        if (!selectedOption.value) {
        if (stockInfo) stockInfo.innerText = `Số Lượng : {{ $variants->sum('stock_quantity') }}`;
        if (priceBox) priceBox.innerText = defaultPriceText;
        addToCartBtn.setAttribute('disabled', true);
        addToCartBtn.innerText = 'Chọn biến thể';
        return;
        }

        // ✅ Nếu đã chọn biến thể
        if (stock > 0) {
        stockInfo.innerText = `Số Lượng : ${stock}`;
        addToCartBtn.removeAttribute('disabled');
        addToCartBtn.innerText = 'Thêm vào giỏ hàng';
        } else {
        stockInfo.innerText = `Sản phẩm đã hết hàng`;
        addToCartBtn.setAttribute('disabled', true);
        addToCartBtn.innerText = 'Sản phẩm đã hết hàng';
        }

        if (priceBox && !isNaN(price)) {
        priceBox.innerText = new Intl.NumberFormat('vi-VN').format(price) + ' đ';
        }
      });
      });
    }
    });




    function changeQty(change) {
    const input = document.querySelector('input[name="quantity"]');
    let value = parseInt(input.value);
    if (!isNaN(value)) {
      value += change;
      if (value < 1) value = 1; input.value = value;
    }
    }
  </script>




@endsection
