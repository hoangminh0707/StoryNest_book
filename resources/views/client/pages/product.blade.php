<?php
?>

@extends('client.layouts.app')

@section('content')

  <style>
    .quantity-input .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
    }

    .variant-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 6px;
    }

    .variant-option {
    padding: 6px 12px;
    border: 1px solid #ccc;
    background: #fff;
    cursor: pointer;
    border-radius: 6px;
    transition: 0.3s;
    }

    .variant-option:hover {
    border-color: #000;
    }

    .variant-option.active {
    background-color: rgb(194, 153, 88);
    color: #fff;
    border-color: #fff;
    }

    .variant-option.disabled {
    background-color: #eee !important;
    color: #999 !important;
    cursor: not-allowed;
    border: 1px solid #ccc !important;
    }

    /* Ẩn mũi tên trên Chrome, Safari, Edge */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Ẩn mũi tên trên Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }

    .wishlist-hover {
    display: inline-flex;
    align-items: center;
    color: #000;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s ease;
    }

    .wishlist-hover i {
    font-size: 18px;
    color: #e53935;
    /* đỏ viền tim */
    margin-right: 6px;
    transition: color 0.3s ease;
    }

    /* Tim viền đỏ (far fa-heart) mặc định */
    .wishlist-hover i.far {
    color: #e53935;
    }

    /* Hover: đổi icon sang tim đầy (fas) và màu đỏ đậm hơn */
    .wishlist-hover:hover i {
    color: #d32f2f;
    }

    /* Hover chữ vẫn màu đen */
    .wishlist-hover:hover {
    color: #000;
    text-decoration: none;
    }


    .border-danger {
    border: 2px dashed red !important;
    border-radius: 8px;
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
        $productVariants = $product->variants;
        $totalStock = $productVariants->sum('stock_quantity');
        $minPrice = $productVariants->min('variant_price');
        $maxPrice = $productVariants->max('variant_price');
        $isAvailable = $product->product_type === 'variable' ? $totalStock > 0 : $product->quantity > 0;
        @endphp
          <!-- Hiển thị giá -->
          <div class="price-box">
            @if ($productVariants->count() === 1)
        <span id="variant-price" class="price-regular">{{ number_format($minPrice) }} đ</span>
        @elseif ($productVariants->count() > 1)
        <span id="variant-price" class="price-regular">{{ number_format($minPrice) }} đ -
        {{ number_format($maxPrice) }} đ</span>
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

          <div class="availability">
          <i class="fa fa-check-circle"></i>
          <span id="stock-info">
          Còn :
          @if ($product->product_type === 'variable')
        {{ $productVariants->sum('stock_quantity') }}
        @else
        {{ $product->quantity }}
        @endif
          sản phẩm
          </span>
          </div>

        <p class="pro-desc">
          {{ \Illuminate\Support\Str::words($product->description, 50, '...') }}
      </p>
          <div class="quantity-cart-box d-flex align-items-center gap-2">
          <h6 class="option-title mb-0">Số lượng:</h6>
          <div class="input-group quantity-input" style="width: 120px;">
          <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQty(-1)">-</button>
          <input type="number" name="quantity" id="quantity-input" class="form-control text-center" value="1"
            min="1">
          <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQty(1)">+</button>
          </div>

          {{-- Thêm vào giỏ --}}
          <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST"
          class="d-inline">
          @csrf
          <input type="hidden" name="variant_id" id="selected-variant-id">
          <input type="hidden" name="price" id="product_price">
          <input type="hidden" name="quantity" value="1" id="add-to-cart-quantity">
          <button type="submit" class="btn btn-cart2" id="add-to-cart-btn">Thêm vào giỏ hàng</button>
          </form>

          {{-- Mua ngay --}}
          <form id="buy-now-form" method="POST" action="{{ route('cart.buy-now') }}" class="d-inline">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="variant_id" id="buy-now-variant-id">
          <input type="hidden" name="quantity" id="buy-now-quantity" value="1">
          <button type="submit" class="btn btn-cart3">Mua ngay</button>
          </form>
          </div>


          <!-- Biến thể -->
          @foreach ($groupedAttributes as $attributeName => $attributeValues)
          @php $uniqueValues = collect($attributeValues)->unique('value'); @endphp
          <div class="pro-size">
          <h6 class="option-title">{{ $attributeName }}</h6>
          <div class="variant-options" data-attribute-name="{{ $attributeName }}">
          @foreach ($uniqueValues as $attr)
        <button type="button" class="variant-option"
          data-value="{{ $attr['value'] }}">{{ $attr['value'] }}</button>
        @endforeach
          </div>
          </div>
        @endforeach
      @else
        <div class="alert alert-warning mt-3">
        <strong>Lưu ý:</strong> Sản phẩm này hiện đã <strong>ngừng kinh doanh</strong> và không thể mua.
        </div>
      @endif



          <div class="useful-links mt-3">
            <div class="useful-links mt-3">
            <a href="{{ route('wishlist.add', $product->id) }}" class="wishlist-hover" data-bs-toggle="tooltip">
              <i class="far fa-heart"></i> <!-- Viền trái tim -->
              <span>Yêu thích</span>
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
              <h5 class="mb-4"><strong>Thông tin chi tiết</strong></h5>

              {{-- Tác giả --}}
              <div class="mb-2">
                <strong>Tác giả:</strong>
                <span>{{ $product->author->name ?? 'Đang cập nhật' }}</span>
              </div>

              {{-- Nhà xuất bản --}}
              <div class="mb-3">
                <strong>Nhà xuất bản:</strong>
                <span>{{ $product->publisher->name ?? 'Đang cập nhật' }}</span>
              </div>

              {{-- Các thuộc tính sản phẩm --}}
                @foreach ($groupedAttributes as $attributeName => $attributeValues)
              <div class="mb-2">
                  <strong>{{ $attributeName }}:</strong>
                  @php
                      // Lấy danh sách các giá trị đã duyệt (unique)
                      $uniqueValues = collect($attributeValues)
                          ->pluck('value')      // lấy mảng các giá trị
                          ->unique()            // loại bỏ trùng
                          ->values();           // reset key index
                  @endphp

                  @foreach ($uniqueValues as $value)
                      <span class="badge bg-primary me-1">{{ $value }}</span>
                  @endforeach
              </div>
          @endforeach
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
            src="{{ Storage::url($review->user->avatar ?? 'https://i.ibb.co/WpKLtySw/Logo-Story-Nest-Book.jpg') }}"
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

              @if ($canReview && !$hasReviewed)
            {{-- Hiện form đánh giá --}}
            <div class="form-group row">
            <div class="col">
            <form id="review-section" action="{{ route('reviews.store') }}" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{ $product->id }}">

              <label class="col-form-label">
              <span class="text-danger">*</span> Đánh giá của bạn
              </label>
              <textarea name="comment" class="form-control" required></textarea>

              <label class="col-form-label mt-3">
              <span class="text-danger">*</span> Đánh giá
              </label>
              @for ($i = 5; $i >= 1; $i--)
          <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
          <label for="star{{ $i }}" style="margin-right: 10px;">{{ $i }} ⭐</label>
          @endfor

              <button type="submit" class="btn btn-sqr mt-3">Gửi đánh giá</button>
            </form>
            </div>
            </div>
        @elseif ($canReview && $hasReviewed)
          <p class="text-success">🎉 Bạn đã đánh giá sản phẩm này. Cảm ơn bạn!</p>
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
          <h2 class="title">Khám Phá Sản Phẩm Liên Quan</h2>
          <p class="sub-title">Tìm thêm những sản phẩm phù hợp với nhu cầu của bạn ngay dưới đây!</p>
        </div>
        <!-- section title end -->
        </div>
      </div>
      <div class="row">
        <div class="col-12">
        <div class="product-carousel-4 slick-row-10 slick-arrow-style">
          <!-- product item start -->

          @foreach ($relatedProducts as $products)

        @php
        $thumbnail = $products->images->where('is_thumbnail', true)->first();
        $secondary = $products->images->where('is_thumbnail', false)->first();
      @endphp

        <div class="product-item">
        <figure class="product-thumb">
          <a href="{{ route('product.show', $products->slug) }}">
          <img class="pri-img"
          src="{{ $thumbnail ? Storage::url($thumbnail->image_path) : asset('images/default.jpg') }}"
          alt="product">
          <img class="sec-img"
          src="{{ $secondary ? Storage::url($secondary->image_path) : asset('images/default.jpg') }}"
          alt="product">
          </a>
          <div class="product-badge">
          <div class="product-label new">
          @if ($products->created_at->gt(\Carbon\Carbon::now()->subDays(7)))
        <span>Mới</span>
        @endif
          </div>
          </div>
          <div class="button-group">
          <a href="{{ route('wishlist.add', $products->id) }}" data-bs-toggle="tooltip"
          data-bs-placement="left" title="Thêm vào yêu thích"><i class="pe-7s-like"></i></a>
          </div>
          <div class="cart-hover">
          @auth
        <form action="{{ route('cart.add', $products->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-cart">Thêm vào giỏ hàng</button>
        </form>
        @endauth

          @guest
        <button onclick="showLoginAlert()" class="btn btn-cart">Thêm vào giỏ hàng</button>
        @endguest
          </div>
        </figure>

        <div class="product-caption text-center">
          <div class="product-identity">
          <p class="manufacturer-name">
          <a href="#">{{ $products->author->name ?? 'Không rõ tác giả' }}</a>
          </p>
          </div>

          <h6 class="product-name">
          <a href="{{ route('product.show', $products->slug) }}">{{ $products->name }}</a>
          </h6>

          @php
        $productVariants = $products->variants;
        if ($productVariants->count() > 0) {
        $minPrice = $productVariants->min('variant_price');
        $maxPrice = $productVariants->max('variant_price');
        }
      @endphp

          <div class="price-box">
          @if ($productVariants->count() === 1)
        <span class="price-regular">{{ number_format($minPrice) }} đ</span>
        @elseif ($productVariants->count() > 1)
        <span class="price-regular">{{ number_format($minPrice) }} đ - {{ number_format($maxPrice) }}
        đ</span>
        @else
        <span class="price-regular">{{ number_format($products->price) }} đ</span>
        @endif
          </div>

        </div>
        </div>

      @endforeach

          <!-- product item end -->
        </div>
        </div>
      </div>
      </div>
    </section>
    <!-- related products area end -->

    @include('client.pages.bestSellingProducts')
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

  @include('client.pages.contact')



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
    const variants = @json($variants);
    const product = @json($product); // Thêm để xử lý sản phẩm không biến thể
    const selectedAttributes = {};
    const variantButtons = document.querySelectorAll('.variant-option');

    const hiddenVariantId = document.getElementById('selected-variant-id');
    const buyNowVariantId = document.getElementById('buy-now-variant-id');
    const productPrice = document.getElementById('product_price');
    const priceBox = document.getElementById('variant-price');
    const quantityInput = document.getElementById('quantity-input');
    const buyNowQtyInput = document.getElementById('buy-now-quantity');
    const addToCartQtyInput = document.getElementById('add-to-cart-quantity');
    const stockInfo = document.getElementById('stock-info');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    const defaultPrice = priceBox?.innerText || '';
    const variantOptionSections = document.querySelectorAll('.variant-options');
    const allAttributeNames = [...variantOptionSections].map(el => el.dataset.attributeName);

    // Xử lý trường hợp không có biến thể
    if (allAttributeNames.length === 0 && variants.length === 0) {
      hiddenVariantId.value = '';
      buyNowVariantId.value = '';
      productPrice.value = product.price || 0;
      priceBox.innerText = new Intl.NumberFormat('vi-VN').format(product.price || 0) + ' đ';
      stockInfo.innerText = `Số lượng: ${product.quantity || 0}`;
      addToCartBtn.disabled = (product.quantity || 0) <= 0;
      if ((product.quantity || 0) <= 0) addToCartBtn.innerText = 'Sản phẩm đã hết hàng';
      else addToCartBtn.innerText = 'Thêm vào giỏ hàng';
      return;
    }

    // Xử lý trường hợp chỉ có 1 biến thể và không cần chọn
    if (allAttributeNames.length === 0 && variants.length === 1) {
      const singleVariant = variants[0];
      hiddenVariantId.value = singleVariant.id;
      buyNowVariantId.value = singleVariant.id;
      productPrice.value = singleVariant.price;
      priceBox.innerText = new Intl.NumberFormat('vi-VN').format(singleVariant.price) + ' đ';
      stockInfo.innerText = `Số lượng: ${singleVariant.stock}`;
      addToCartBtn.disabled = singleVariant.stock <= 0;
      if (singleVariant.stock <= 0) addToCartBtn.innerText = 'Sản phẩm đã hết hàng';
      else addToCartBtn.innerText = 'Thêm vào giỏ hàng';
      return;
    }

    // Xử lý khi bấm chọn thuộc tính biến thể
    variantButtons.forEach(btn => {
      const attrName = btn.closest('.variant-options').dataset.attributeName;

      btn.addEventListener('click', () => {
      btn.closest('.variant-options').querySelectorAll('.variant-option').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      selectedAttributes[attrName] = btn.dataset.value;
      btn.closest('.variant-options').classList.remove('border-danger');

      // Nếu đã chọn đầy đủ thuộc tính, cập nhật biến thể tương ứng
      const isFullySelected = allAttributeNames.every(attr => selectedAttributes[attr]);
      if (isFullySelected) {
        const matchedVariant = findMatchedVariant();
        if (matchedVariant) {
        updateMatchedVariant(matchedVariant);
        }
      }
      });
    });

    // Xử lý submit form Thêm vào giỏ và Mua ngay
    document.getElementById('add-to-cart-form')?.addEventListener('submit', function (e) {
      if (!validateBeforeSubmit()) e.preventDefault();
    });

    document.getElementById('buy-now-form')?.addEventListener('submit', function (e) {
      if (!validateBeforeSubmit()) e.preventDefault();
    });

    // Đồng bộ số lượng input
    quantityInput.addEventListener('input', () => {
      const qty = parseInt(quantityInput.value);
      buyNowQtyInput.value = qty;
      addToCartQtyInput.value = qty;

      const selectedId = hiddenVariantId.value;
      const matched = variants.find(v => v.id == selectedId);
      if (matched && qty > matched.stock) {
      showError('Vượt quá số lượng kho!', `Chỉ còn ${matched.stock} sản phẩm có sẵn.`);
      quantityInput.value = matched.stock;
      buyNowQtyInput.value = matched.stock;
      addToCartQtyInput.value = matched.stock;
      }
    });

    // Tăng giảm số lượng
    window.changeQty = function (change) {
      let value = parseInt(quantityInput.value);
      if (!isNaN(value)) {
      value += change;
      if (value < 1) value = 1;
      quantityInput.value = value;
      buyNowQtyInput.value = value;
      addToCartQtyInput.value = value;

      const selectedId = hiddenVariantId.value;
      const matched = variants.find(v => v.id == selectedId);
      if (matched && value > matched.stock) {
        showError('Vượt quá số lượng kho!', `Chỉ còn ${matched.stock} sản phẩm có sẵn.`);
        quantityInput.value = matched.stock;
        buyNowQtyInput.value = matched.stock;
        addToCartQtyInput.value = matched.stock;
      }
      }
    };

    // Validate trước khi submit form
    function validateBeforeSubmit() {
      // Với sản phẩm có biến thể thì phải chọn đủ thuộc tính
      if (allAttributeNames.length > 0) {
      const isFullySelected = allAttributeNames.every(attr => selectedAttributes[attr]);

      if (!isFullySelected) {
        highlightMissingAttributes();
        showError('Thiếu thông tin!', 'Vui lòng chọn đầy đủ biến thể sản phẩm trước khi tiếp tục.');
        return false;
      }

      const matchedVariant = findMatchedVariant();

      if (!matchedVariant) {
        showError('Không tìm thấy biến thể phù hợp!', 'Vui lòng kiểm tra lại lựa chọn của bạn.');
        return false;
      }

      if (matchedVariant.stock <= 0) {
        showError('Sản phẩm đã hết hàng!', 'Vui lòng chọn biến thể khác.');
        return false;
      }

      const qty = parseInt(quantityInput.value);
      if (qty > matchedVariant.stock) {
        showError('Vượt quá số lượng kho!', `Chỉ còn ${matchedVariant.stock} sản phẩm có sẵn.`);
        return false;
      }

      updateMatchedVariant(matchedVariant);
      return true;
      }

      // Với sản phẩm không có biến thể, kiểm tra tồn kho
      if ((product.quantity || 0) <= 0) {
      showError('Sản phẩm đã hết hàng!', 'Sản phẩm hiện tại đã hết hàng.');
      return false;
      }
      const qty = parseInt(quantityInput.value);
      if (qty > (product.quantity || 0)) {
      showError('Vượt quá số lượng kho!', `Chỉ còn ${product.quantity || 0} sản phẩm có sẵn.`);
      return false;
      }

      return true;
    }

    // Tìm biến thể khớp với thuộc tính đã chọn
    function findMatchedVariant() {
      return variants.find(variant =>
      allAttributeNames.every(attrName =>
        variant.attribute_values.some(attr =>
        attr.attribute.name === attrName && attr.value === selectedAttributes[attrName]
        )
      )
      );
    }

    // Cập nhật UI khi có biến thể được chọn
    function updateMatchedVariant(variant) {
      hiddenVariantId.value = variant.id;
      buyNowVariantId.value = variant.id;
      productPrice.value = variant.price;
      priceBox.innerText = new Intl.NumberFormat('vi-VN').format(variant.price) + ' đ';

      if (variant.stock > 0) {
      addToCartBtn.disabled = false;
      addToCartBtn.innerText = 'Thêm vào giỏ hàng';
      stockInfo.innerText = `Số lượng: ${variant.stock}`;
      } else {
      addToCartBtn.disabled = true;
      addToCartBtn.innerText = 'Sản phẩm đã hết hàng';
      stockInfo.innerText = 'Sản phẩm đã hết hàng';
      }
    }

    // Làm nổi bật các nhóm thuộc tính chưa chọn
    function highlightMissingAttributes() {
      document.querySelectorAll('.variant-options').forEach(group => {
      const attrName = group.dataset.attributeName;
      if (!selectedAttributes[attrName]) {
        const buttons = group.querySelectorAll('.variant-option');
        buttons.forEach(btn => btn.classList.add('border-danger'));
      }
      });

      const scrollTo = document.querySelector('.variant-options');
      if (scrollTo) scrollTo.scrollIntoView({ behavior: 'smooth' });
    }

    // Hiển thị popup lỗi
    function showError(title, text) {
      Swal.fire({
      icon: 'warning',
      title: title,
      text: text,
      timer: 3000,
      showConfirmButton: false
      });
    }
    });
  </script>



@endsection