<?php
?>

@extends('client.layouts.app')

@section('content')

  <style>
    .quantity-input .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.9rem;
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
          <div class="product-voucher">
            <ul class="voucher-list">
            @foreach ($vouchers as $voucher)
          <li style="padding: 5px; margin-bottom: 5px; background: #f5f5f5; border-radius: 5px;">
            <span style="font-weight: bold; color: #ff5722;">{{ $voucher->code }}</span>:
            @if ($voucher->type === "fixed")
          Giảm {{ number_format($voucher->value) }} đ
        @else
          Giảm {{ number_format($voucher->value) }}%
        @endif
            @if ($voucher->expires_at)
          <small style="color: gray;">(HSD:
          {{ \Carbon\Carbon::parse($voucher->expires_at)->format('d/m/Y') }})</small>
        @endif
          </li>
        @endforeach
            </ul>
          </div>
          <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST"
            style="display:inline;">
            @csrf
            <input type="hidden" name="price" id="product_price">
            <input type="hidden" name="product_variant_id" id="product_variant_id">

            <div class="availability">
            <i class="fa fa-check-circle"></i>
            <span>Số Lượng : {{ $product->quantity }}</span>
            </div>
            <p class="pro-desc">{{ $product->description }}</p>
            <div class="quantity-cart-box d-flex align-items-center gap-2">
            <h6 class="option-title mb-0">SL:</h6>
            <div class="input-group quantity-input" style="width: 120px;">
              <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQty(-1)">-</button>
              <input type="number" name="quantity" class="form-control text-center" value="1" min="1">
              <button class="btn btn-outline-secondary btn-sm" type="button" onclick="changeQty(1)">+</button>
            </div>

            <div class="action_link">
              @if ($product->quantity > 0)
          <button type="submit" class="btn btn-cart2" id="add-to-cart-btn">
          Thêm vào giỏ hàng
          </button>
        @else
          <button class="btn btn-cart2" id="add-to-cart-btn" disabled>
          Sản phẩm đã hết hàng
          </button>
        @endif
            </div>
            </div>


            @foreach ($groupedAttributes as $attributeName => $attributeValues)
          <div class="pro-size">
          <h6 class="option-title">{{ $attributeName }} </h6>
          <select name="variant_id" id="{{ strtolower($attributeName) }}_variant_id" class="form-control"
          style="width : 100% ; max-width: 120px;">
          <option value="">Chọn {{ $attributeName }}</option>
          @foreach ($attributeValues as $attribute)
        <option value="{{ $attribute['variant_id'] }}"
        data-price="{{ number_format($attribute['price'])  }}">
        {{ $attribute['value'] }}
        </option>
        @endforeach
          </select>
          </div>
        @endforeach
          </form>

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








  <script>
    window.onload = function () {
    document.querySelectorAll('.form-control').forEach(function (selectElement) {
      selectElement.addEventListener('change', function () {
      let selectedOption = selectElement.options[selectElement.selectedIndex];
      // console.log('Selected option:', selectedOption);  // Kiểm tra option đã chọn

      let newPrice = selectedOption.dataset.price;
      // console.log('Selected price:', newPrice);  // Kiểm tra giá trị data-price

      if (newPrice) {
        document.getElementById('product-price').innerText = newPrice.toLocaleString() + " đ";
      } else {
        document.getElementById('product-price').innerText = '{{ number_format($product->price) }} đ';
      }
      });
    });
    };

    function changeQty(change) {
    const input = document.querySelector('input[name="quantity"]');
    let value = parseInt(input.value);
    if (!isNaN(value)) {
      value += change;
      if (value < 1) value = 1;
      input.value = value;
    }
    }


  </script>




@endsection