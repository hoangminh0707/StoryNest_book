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
    @foreach ($banners as $banner)
      @if (!empty($banner->image_url))
      <div class="hero-single-slide hero-overlay">
      <div class="hero-slider-item bg-img" data-bg="{{ asset('storage/' . $banner->image_url) }}">
      </div>
      </div>
      @endif
    @endforeach

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
       <h6>Đảm bảo chất lượng</h6>
      <p>Sản phẩm chính hãng, kiểm định kỹ lưỡng</p>
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

@include('client.pages.flash_sale_section')

@include('client.pages.products_new', ['productsByCategory' => $productsByCategory])
@include('client.pages.bestSellingProducts')







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
    document.addEventListener('DOMContentLoaded', function () {
    const quickViewButtons = document.querySelectorAll('.btn-quick-view');

    quickViewButtons.forEach(button => {
      button.addEventListener('click', function () {
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