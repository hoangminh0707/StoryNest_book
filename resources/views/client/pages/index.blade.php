<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')
@section('active_pages_index', 'active')

@section('content')

<style>
  .product-image {
    width: 100%;
    /* ảnh luôn chiếm 100% chiều rộng thẻ cha */
    height: 300px;
    /* hoặc 250px/300px tùy giao diện bạn */
    object-fit: cover;
    /* CỰC KỲ QUAN TRỌNG: ảnh sẽ zoom và cắt cho vừa khung, không méo */
    border-radius: 8px;
    /* bo nhẹ 8px cho ảnh nhìn mềm mại hơn */
    transition: 0.3s ease;
    /* thêm hiệu ứng mượt khi hover (nếu cần) */
  }

  .product-image:hover {
    transform: scale(1.05);
    /* hover phóng to nhẹ ảnh */
  }


  .img-model {
    width: 100%;
    /* Đảm bảo ảnh chiếm toàn bộ chiều rộng của phần tử chứa */
    height: auto;
    /* Giữ tỉ lệ khung hình của ảnh */
    max-width: 200px;
    /* Giới hạn chiều rộng tối đa của ảnh */
    display: block;
    /* Loại bỏ khoảng trống dưới ảnh */
    margin: 0 auto;
    /* Căn giữa ảnh */
  }
</style>

<section class="slider-area hero-style-five">
  <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
    <div class="hero-single-slide hero-overlay">
      <div class="hero-slider-item bg-img" data-bg="assets/img/slider/home3-slide2.jpg">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="hero-slider-content slide-1">
                <h2 class="slide-title">Family Jewelry <span>Collection</span></h2>
                <h4 class="slide-desc">Designer Jewelry Necklaces-Bracelets-Earings</h4>
                <a href="shop.html" class="btn btn-hero">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-single-slide hero-overlay">
      <div class="hero-slider-item bg-img" data-bg="assets/img/slider/home1-slide3.jpg">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="hero-slider-content slide-2 float-md-end float-none">
                <h2 class="slide-title">Diamonds Jewellery<span>Collection</span></h2>
                <h4 class="slide-desc">Shukra Yogam &amp; Silver Power Silver Saving Schemes.</h4>
                <a href="shop.html" class="btn btn-hero">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-single-slide hero-overlay">
      <div class="hero-slider-item bg-img" data-bg="assets/img/slider/home3-slide1.jpg">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="hero-slider-content slide-3">
                <h2 class="slide-title">Grace Designer<span>Jewellery</span></h2>
                <h4 class="slide-desc">Rings, Occasion Pieces, Pandora &amp; More.</h4>
                <a href="shop.html" class="btn btn-hero">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="service-policy">
  <div class="container">
    <div class="policy-block section-padding">
      <div class="row mtn-30 text-center">

        <div class="col-sm col-lg">
          <div class="policy-item">
            <div class="policy-icon">
              <i class="pe-7s-help2"></i>
            </div>
            <div class="policy-content">
              <h6>Hỗ trợ 24/7</h6>
              <p>Hỗ trợ 24 giờ trong ngày</p>
            </div>
          </div>
        </div>
        <div class="col-sm col-lg">
          <div class="policy-item">
            <div class="policy-icon">
              <i class="pe-7s-back"></i>
            </div>
            <div class="policy-content">
              <h6>Hoàn trả</h6>
              <p>Trong 30 ngày miễn phí hoàn trả</p>
            </div>
          </div>
        </div>
        <div class="col-sm col-lg">
          <div class="policy-item">
            <div class="policy-icon">
              <i class="pe-7s-credit"></i>
            </div>
            <div class="policy-content">
              <h6>100% Thanh toán an toàn</h6>
              <p>Chúng tôi đảm bảo về báo mật thanh toán của bạn</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<section class="product-area section-padding">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- section title start -->
        <div class="section-title text-center">
          <h2 class="title">Sản phẩm mới</h2>
          <p class="sub-title">Thêm sản phẩm của chúng tôi vào danh sách hàng tuần</p>
        </div>
        <!-- section title start -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="product-container">
          <!-- product tab menu start -->
          <div class="product-tab-menu">
            <ul class="nav justify-content-center">
              <li><a href="#tab1" class="active" data-bs-toggle="tab">Sách</a></li>
              <li><a href="#tab2" data-bs-toggle="tab" class="">Bút</a></li>
              <li><a href="#tab3" data-bs-toggle="tab" class="">Truyện tranh</a></li>
              <li><a href="#tab4" data-bs-toggle="tab" class="">Khác</a></li>
            </ul>
          </div>
          <!-- product tab menu end -->

          <!-- product tab content start -->
          <div class="tab-content">
            <div class="tab-pane fade show active" id="tab1">
              <div class="product-carousel-4 slick-row-10 slick-arrow-style">

                @foreach($products as $product)

                @php
                $thumbnail = $product->images->where('is_thumbnail', true)->first();
                $otherImage = $product->images->where('is_thumbnail', false)->first();
                @endphp

                <!-- product item start -->
                <div class="product-item">
                  <figure class="product-thumb">
                    <a href="{{ route('product.show', $product->id) }}">
                      @if ($thumbnail)
                      <img class="pri-img product-image" src="{{ Storage::url($thumbnail->image_path) }}" alt="product">
                      @endif

                      @if ($otherImage)
                      <img class="sec-img product-image" src="{{ Storage::url($otherImage->image_path) }}"
                        alt="product">
                      @endif
                    </a>
                    <div class="product-badge">
                      <div class="product-label discount">
                        <span>new</span>
                      </div>
                    </div>
                    <div class="button-group">
                      @auth
                      <a href="{{ route('wishlist.add', $product->id) }}" data-bs-toggle="tooltip"
                        data-bs-placement="left" title="Add to wishlist"><i class="pe-7s-like"></i></a>
                      @endauth

                      @guest
                      <a href="#" onclick="showLoginAlert()" data-bs-toggle="tooltip" data-bs-placement="left"
                        title="Add to wishlist"><i class="pe-7s-like"></i></a>
                      @endguest


                      <a href="#" class="btn-quick-view" data-name="{{ $product->name }}"
                        data-price="{{ number_format($product->price) }}" data-description="{{ $product->description }}"
                        data-stock="{{ $product->quantity }}" data-author="{{ $product->author->name ?? 'Unknown' }}"
                        data-images='@json($product->images->pluck("image_path"))' data-bs-toggle="modal"
                        data-bs-target="#quick_view"><span data-bs-toggle="tooltip" data-bs-placement="left"
                          title="Quick View"><i class="pe-7s-search"></i></span></a>
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
                  <div class="product-caption">
                    <div class="product-identity">
                      <p class="manufacturer-name"><a href="product-details.html">{{ $product->author->name }}</a></p>
                    </div>
                    <h6 class="product-name">
                      <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                    </h6>
                    <div class="price-box">
                      <span class="price-regular">{{ number_format($product->price) }} đ</span>

                    </div>
                  </div>
                </div>
                <!-- product item end -->
                @endforeach

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>






<!-- Quick view modal start -->
<div class="modal" id="quick_view">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <!-- product details inner end -->
        <div class="product-details-inner">
          <div class="row">
            <div class="col-lg-5">
              <div class="product-large-slider" id="quick-view-large-slider">
                <!-- Ảnh lớn sẽ append vào đây -->
              </div>
              <div class="pro-nav slick-row-10 slick-arrow-style" id="quick-view-thumb-slider">
                <!-- Ảnh nhỏ sẽ append vào đây -->
              </div>
            </div>
            <div class="col-lg-7">
              <div class="product-details-des">
                <div class="manufacturer-name">
                  <a href="product-details.html" id="quick-view-author"></a>
                </div>
                <h3 class="product-name" id="quick-view-name"></h3>
                <div class="ratings d-flex">
                  <span><i class="fa fa-star-o"></i></span>
                  <span><i class="fa fa-star-o"></i></span>
                  <span><i class="fa fa-star-o"></i></span>
                  <span><i class="fa fa-star-o"></i></span>
                  <span><i class="fa fa-star-o"></i></span>
                  <div class="pro-review">
                    <span id="quick-view-reviews">1 Reviews</span>
                  </div>
                </div>
                <div class="price-box">
                  <span class="price-regular" id="quick-view-price"></span>
                </div>

                <div class="availability">
                  <i class="fa fa-check-circle"></i>
                  <span id="quick-view-stock"></span>
                </div>
                <p class="pro-desc" id="quick-view-description">

                </p>


              </div>
            </div>
          </div>
        </div> <!-- product details inner end -->
      </div>
    </div>
  </div>
</div>
<!-- Quick view modal end -->





<script>
  document.addEventListener('DOMContentLoaded', function() {
    const quickViewButtons = document.querySelectorAll('.btn-quick-view');

    quickViewButtons.forEach(button => {
      button.addEventListener('click', function() {
        // 1. Lấy data
        const name = this.getAttribute('data-name') || '';
        const price = this.getAttribute('data-price') || '';
        const description = this.getAttribute('data-description') || '';
        const stock = this.getAttribute('data-stock') || '';
        const author = this.getAttribute('data-author') || '';
        let images = [];

        try {
          images = JSON.parse(this.getAttribute('data-images') || '[]');
        } catch (e) {
          console.error('Invalid JSON in data-images', e);
        }

        // 2. Đổ text vào Modal
        document.getElementById('quick-view-name').textContent = name;
        document.getElementById('quick-view-price').textContent = price + '₫';
        document.getElementById('quick-view-description').textContent = description;
        document.getElementById('quick-view-stock').textContent = `${stock} in stock`;
        document.getElementById('quick-view-author').textContent = author;

        // 3. Lấy 2 container ảnh
        const largeSlider = document.getElementById('quick-view-large-slider');
        const thumbSlider = document.getElementById('quick-view-thumb-slider');

        // 4. Destroy slick cũ nếu đã init
        if ($(largeSlider).hasClass('slick-initialized')) {
          $(largeSlider).slick('unslick');
        }
        if ($(thumbSlider).hasClass('slick-initialized')) {
          $(thumbSlider).slick('unslick');
        }

        // 5. Clear HTML cũ
        largeSlider.innerHTML = '';
        thumbSlider.innerHTML = '';

        // 6. Append ảnh mới
        images.forEach(img => {
          // đảm bảo img là đường dẫn hợp lệ
          const url = img.startsWith('http') ? img : window.location.origin + '/storage/' + img.replace(/^\/+/, '');

          largeSlider.insertAdjacentHTML('beforeend', `
      <div class="pro-large-img img-zoom">
      <img class="img-model" src="${url}" alt="product-details" />
      </div>
      `);

          thumbSlider.insertAdjacentHTML('beforeend', `
      <div class="pro-nav-thumb">
      <img class="img-model" src="${url}" alt="product-details" />
      </div>
      `);
        });

        // 7. Init lại slick
        $(largeSlider).slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          fade: true,
          asNavFor: '#quick-view-thumb-slider'
        });
        $(thumbSlider).slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          asNavFor: '#quick-view-large-slider',
          dots: false,
          centerMode: false,
          focusOnSelect: true
        });

        // 8. Reset qty input
        document.getElementById('quick-view-qty-input').value = 1;
      });
    });
  });
</script>



@endsection