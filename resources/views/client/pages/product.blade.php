<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

  <style>
    .select-item.active {
    border: 2px solid #007bff;
    border-radius: 6px;
    background-color: #e9f2ff;
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
          <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-home"></i></a></li>
          <li class="breadcrumb-item"><a href="shop.html">shop</a></li>
          <li class="breadcrumb-item active" aria-current="page">variable products</li>
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
            <div class="pro-large-img img-zoom">
            @if($thumbnail)
        <img src="{{ Storage::url($thumbnail->image_path) }}" alt="product-details"
          style="width : 100% ; max-width: 300px; height: 100%; max-height: 335px;">
        </div>
      @endif
            @foreach($otherImages as $index => $image)
        <div class="pro-large-img img-zoom">
        <img src="{{ Storage::url($image->image_path)}}" alt="product-details"
          style="width : 100% ; max-width: 300px; height: 100%; max-height: 335px;">
        </div>
      @endforeach
          </div>
          <div class="pro-nav slick-row-10 slick-arrow-style">
            @foreach($otherImages as $index => $image)
        <div class="pro-nav-thumb">
        <img src="{{ Storage::url($image->image_path)}}" alt="product-details"
          style="width : 100% ; max-width: 120px;">
        </div>
      @endforeach

          </div>
          </div>
          <div class="col-lg-7">
          <div class="product-details-des">
            <div class="manufacturer-name">
            <a href="product-details.html">{{ $product->author->name }}</a>
            </div>
            <h3 class="product-name">{{ $product->name }}</h3>
            <div class="ratings d-flex">
            <span><i class="fa fa-star-o"></i></span>
            <span><i class="fa fa-star-o"></i></span>
            <span><i class="fa fa-star-o"></i></span>
            <span><i class="fa fa-star-o"></i></span>
            <span><i class="fa fa-star-o"></i></span>
            <div class="pro-review">
              <span>1 Reviews</span>
            </div>
            </div>
            <div class="price-box">
            <span class="price-regular" id="product-price">{{ number_format($product->price)}} đ</span>
            </div>

            <div class="product-countdown" data-countdown="2022/12/30"></div>
            <form id="add-to-cart-form" action="{{ route('cart.add', $product->id) }}" method="POST"
            style="display:inline;">
            @csrf
            <input type="hidden" name="price" id="product_price">
            <input type="hidden" name="product_variant_id" id="product_variant_id">

            <div class="availability">
              <i class="fa fa-check-circle"></i>
              <span>Số Lượng : {{ $product->quantity }}</span>
            </div>

            {{--
            <pre>{{ $product }}</pre> --}}

            <p class="pro-desc">{{ $product->description }}</p>

            <div class="quantity-cart-box d-flex align-items-center">
              <h6 class="option-title">SL:</h6>
              <div class="quantity">
              <div class="pro-qty">
                <input type="text" value="1" name="quantity">
              </div>
              </div>
              <div class="action_link">
              <button type="submit" class="btn btn-cart2" id="add-to-cart-btn">
                Add to cart
              </button>
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
              <a class="active" data-bs-toggle="tab" href="#tab_one">description</a>
              </li>
              <li>
              <a data-bs-toggle="tab" href="#tab_two">information</a>
              </li>
              <li>
              <a data-bs-toggle="tab" href="#tab_three">reviews (1)</a>
              </li>
            </ul>
            <div class="tab-content reviews-tab">
              <div class="tab-pane fade show active" id="tab_one">
              <div class="tab-one">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam
                fringilla augue nec est tristique auctor. Ipsum metus feugiat
                sem, quis fermentum turpis eros eget velit. Donec ac tempus
                ante. Fusce ultricies massa massa. Fusce aliquam, purus eget
                sagittis vulputate, sapien libero hendrerit est, sed commodo
                augue nisi non neque.Cras neque metus, consequat et blandit et,
                luctus a nunc. Etiam gravida vehicula tellus, in imperdiet
                ligula euismod eget. Pellentesque habitant morbi tristique
                senectus et netus et malesuada fames ac turpis egestas. Nam
                erat mi, rutrum at sollicitudin rhoncus</p>
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
              <form action="#" class="review-form">
                <h5>1 review for <span>Chaz Kangeroo</span></h5>
                <div class="total-reviews">
                <div class="rev-avatar">
                  <img src="assets/img/about/avatar.jpg" alt="">
                </div>
                <div class="review-box">
                  <div class="ratings">
                  <span class="good"><i class="fa fa-star"></i></span>
                  <span class="good"><i class="fa fa-star"></i></span>
                  <span class="good"><i class="fa fa-star"></i></span>
                  <span class="good"><i class="fa fa-star"></i></span>
                  <span><i class="fa fa-star"></i></span>
                  </div>
                  <div class="post-author">
                  <p><span>admin -</span> 30 Mar, 2019</p>
                  </div>
                  <p>Aliquam fringilla euismod risus ac bibendum. Sed sit
                  amet sem varius ante feugiat lacinia. Nunc ipsum nulla,
                  vulputate ut venenatis vitae, malesuada ut mi. Quisque
                  iaculis, dui congue placerat pretium, augue erat
                  accumsan lacus</p>
                </div>
                </div>
                <div class="form-group row">
                <div class="col">
                  <label class="col-form-label"><span class="text-danger">*</span>
                  Your Name</label>
                  <input type="text" class="form-control" required>
                </div>
                </div>
                <div class="form-group row">
                <div class="col">
                  <label class="col-form-label"><span class="text-danger">*</span>
                  Your Email</label>
                  <input type="email" class="form-control" required>
                </div>
                </div>
                <div class="form-group row">
                <div class="col">
                  <label class="col-form-label"><span class="text-danger">*</span>
                  Your Review</label>
                  <textarea class="form-control" required></textarea>
                  <div class="help-block pt-10"><span class="text-danger">Note:</span>
                  HTML is not translated!
                  </div>
                </div>
                </div>
                <div class="form-group row">
                <div class="col">
                  <label class="col-form-label"><span class="text-danger">*</span>
                  Rating</label>
                  &nbsp;&nbsp;&nbsp; Bad&nbsp;
                  <input type="radio" value="1" name="rating">
                  &nbsp;
                  <input type="radio" value="2" name="rating">
                  &nbsp;
                  <input type="radio" value="3" name="rating">
                  &nbsp;
                  <input type="radio" value="4" name="rating">
                  &nbsp;
                  <input type="radio" value="5" name="rating" checked>
                  &nbsp;Good
                </div>
                </div>
                <div class="buttons">
                <button class="btn btn-sqr" type="submit">Continue</button>
                </div>
              </form> <!-- end of review-form -->
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
          <a href="{{ route('product.show', $product->id) }}">

          <img class="pri-img" src="{{ storage::url($thumbnail->image_path) }}" alt="product">
          <img class="sec-img" src="{{ storage::url($secondary->image_path) }}" alt="product">
          </a>
          <div class="product-badge">
          <div class="product-label new">
            <span>new</span>
          </div>
          </div>
          <div class="button-group">
          <a href="wishlist.html" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist"><i
            class="pe-7s-like"></i></a>
          <a href="compare.html" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Compare"><i
            class="pe-7s-refresh-2"></i></a>
          <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view">
            <span data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View">
            <i class="pe-7s-search"></i>
            </span>
          </a>
          </div>
          <div class="cart-hover">
          <button class="btn btn-cart">Add to cart</button>
          </div>
          </figure>

          <div class="product-caption text-center">
          <div class="product-identity">
          <p class="manufacturer-name">
            <a href="#">{{ $product->author->name ?? 'Không rõ tác giả' }}</a>
          </p>
          </div>

          <h6 class="product-name">
          <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
          </h6>

          <div class="price-box">
          <span class="price-regular">{{ number_format($product->price) }}₫</span>

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


  </script>




@endsection