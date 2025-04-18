
<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('active_pages_shop','active')

@section('content')

<section class="hero-section position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>Shop</h1>
            <div class="breadcrumbs">
              <span class="item text-decoration-underline">Shop</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="shopify-grid padding-large">
    <div class="container">
      <div class="row flex-row-reverse g-md-5">
        <main class="col-md-9">
          <div class="filter-shop d-flex flex-wrap justify-content-between mb-5">
            <div class="showing-product">
              <p>Hiển thị từ {{ $products->firstItem() }}–{{ $products->lastItem() }} trong tổng {{ $products->total() }} sản phẩm</p>
            </div>
           
          </div>
          <div class="row product-content product-store">
            @foreach ($products as $product)

            <div class="col-lg-3 col-md-4 mb-4">
              <div class="card position-relative p-4 border rounded-3">
                <div class="position-absolute">
                  {{-- <p class="bg-primary py-1 px-3 fs-6 text-white rounded-2">10% off</p> --}}
                </div>
                

                @if($product->images->isNotEmpty())
                <img src="{{ Storage::url($product->images->first()->image_path) }}" alt="{{ $product->name }}" 
                class="img-fluid shadow-sm" alt="{{ $product->name}}">
                @endif
                
                
                <h6 class="mt-4 mb-0 fw-bold"><a href="{{ route('product.show',$product->id) }}">{{ $product->name}}</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">{{ $product->author->name}}</p>

                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                    <svg class="star star-fill">
                      <use xlink:href="#star-fill"></use>
                    </svg>
                  </div>
                </div>

                <span class="price text-primary fw-bold mb-2 fs-5">{{ number_format($product->price) }} <strong>VND</strong></span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                    <svg class="cart">
                      <use xlink:href="#cart"></use>
                    </svg>
                  </button>
                  <a href="#" class="btn btn-dark">
                    <span>
                      <svg class="wishlist">
                        <use xlink:href="#heart"></use>
                      </svg>
                    </span>
                  </a>
                </div>
              </div>
            </div>
              
            @endforeach
          </div>



          

          <nav class="py-5" aria-label="Page navigation">
            <ul class="pagination justify-content-center gap-4">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">Prev</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Prev</a>
                    </li>
                @endif
        
                {{-- Pagination Elements --}}
                @foreach ($products->links()->elements as $element)
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif
        
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $products->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
        
                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">Next</span>
                    </li>
                @endif
            </ul>
        </nav>
        
                        
  
          
      
        </main>
        <aside class="col-md-3">
          <div class="sidebar ps-lg-5">
            <div class="widget-menu">
              <div class="widget-search-bar">
                <form class="d-flex border rounded-3 p-2" role="search">
                  <input class="form-control border-0 me-2 py-2" type="text" id="search" placeholder="Search" aria-label="Search" name="search" value="{{ request('search') }}">
                  <button class="btn rounded-3 p-3 d-flex align-items-center" type="submit">
                    <svg class="search text-light" width="18" height="18">
                      <use xlink:href="#search"></use>
                    </svg>
                  </button>
                </form>
              </div>
            </div>
            <div class="widget-product-categories pt-5">
              <div class="section-title overflow-hidden mb-2">
                <h3 class="d-flex flex-column mb-0">Thể loại</h3>
              </div>
              <ul class="product-categories mb-0 sidebar-list list-unstyled">

                <li class="cat-item">
                  <a href="{{ route('shop') }}">Tất cả thể loại</a>
                </li>
                
                @foreach($categories as $category)
                <li class="cat-item">
                  <a href="{{ route('shop', ['category_id' => $category->id]) }}" {{ request('category_id') == $category->id ? 'class=active' : '' }}>
                    {{ $category->name }}</a>
                </li>
                @endforeach
               
              </ul>
            </div>
        
              
            <div class="widget-product-authur pt-5">
              <div class="section-title overflow-hidden mb-2">
                <h3 class="d-flex flex-column mb-0">Tác giả</h3>
              </div>
              <ul class="product-tags mb-0 sidebar-list list-unstyled">
                @foreach($authors as $author)
                <li class="tags-item">
                  <a href="{{ route('shop', ['author_id' => $author->id]) }}" {{ request('author_id') == $author->id ? 'class=active' : '' }}>
                    {{ $author->name }}</a>
                </li>
                @endforeach
              </ul>
            </div>
           
          </div>
        </aside>
      </div>
    </div>
  </div>

  <section id="customers-reviews" class="position-relative padding-large"
  style="background-image: url(assetClient/images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 600px;">
  <div class="container offset-md-3 col-md-6 ">
    <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next testimonial-button-next">
      <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
        <use xlink:href="#alt-arrow-right-outline"></use>
      </svg>
    </div>
    <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev testimonial-button-prev">
      <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
        <use xlink:href="#alt-arrow-left-outline"></use>
      </svg>
    </div>
    <div class="section-title mb-4 text-center">
      <h3 class="mb-4">Đánh giá của khách hàng</h3>
    </div>
    <div class="swiper testimonial-swiper ">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="card position-relative text-left p-5 border rounded-3">
            <blockquote>"Tôi tình cờ tìm thấy hiệu sách này khi đến thăm thành phố và nó ngay lập tức trở thành địa điểm yêu thích của tôi. Không khí ấm cúng, đội ngũ nhân viên thân thiện và nhiều loại sách khiến mỗi lần ghé thăm đều là một niềm vui!"</blockquote>
            <div class="rating text-warning d-flex align-items-center">
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
            </div>
            <h5 class="mt-1 fw-normal">Emma Chamberlin</h5>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card position-relative text-left p-5 border rounded-3">
            <blockquote>"Là một độc giả cuồng nhiệt, tôi luôn tìm kiếm những tác phẩm mới phát hành và hiệu sách này không bao giờ làm tôi thất vọng. Họ luôn có những tựa sách mới nhất và những đề xuất của họ đã giới thiệu cho tôi một số tác phẩm đáng kinh ngạc!"</blockquote>
            <div class="rating text-warning d-flex align-items-center">
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
            </div>
            <h5 class="mt-1 fw-normal">Thomas John</h5>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card position-relative text-left p-5 border rounded-3">
            <blockquote>"Tôi đã đặt mua một vài cuốn sách trực tuyến từ cửa hàng này và tôi rất ấn tượng với dịch vụ giao hàng nhanh chóng và đóng gói cẩn thận. Rõ ràng là họ ưu tiên sự hài lòng của khách hàng và tôi chắc chắn sẽ mua sắm ở đây một lần nữa!"</blockquote>
            <div class="rating text-warning d-flex align-items-center">
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
            </div>
            <h5 class="mt-1 fw-normal">Kevin Bryan</h5>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card position-relative text-left p-5 border rounded-3">
            <blockquote>“Tôi tình cờ tìm thấy cửa hàng công nghệ này khi đang tìm kiếm một chiếc máy tính xách tay mới và tôi không thể hài lòng hơn
                với trải nghiệm của mình! Đội ngũ nhân viên vô cùng hiểu biết và hướng dẫn tôi trong suốt quá trình lựa chọn
                thiết bị hoàn hảo cho nhu cầu của mình. Rất đáng để giới thiệu!”</blockquote>
            <div class="rating text-warning d-flex align-items-center">
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
            </div>
            <h5 class="mt-1 fw-normal">Stevin</h5>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="card position-relative text-left p-5 border rounded-3">
            <blockquote>“Tôi tình cờ tìm thấy cửa hàng công nghệ này khi đang tìm kiếm một chiếc máy tính xách tay mới và tôi không thể hài lòng hơn
                với trải nghiệm của mình! Đội ngũ nhân viên vô cùng hiểu biết và hướng dẫn tôi trong suốt quá trình lựa chọn
                thiết bị hoàn hảo cho nhu cầu của mình. Rất đáng để giới thiệu!”</blockquote>
            <div class="rating text-warning d-flex align-items-center">
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
              <svg class="star star-fill">
                <use xlink:href="#star-fill"></use>
              </svg>
            </div>
            <h5 class="mt-1 fw-normal">Roman</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



  <section id="latest-posts" class="padding-large">
  <div class="container">
    <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
      <h3 class="d-flex align-items-center">Bài viết mới nhất</h3>
      <a href="shop.html" class="btn">Xem tất cả</a>
    </div>
    <div class="row">
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item1.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">10 cuốn sách nhất định phải đọc trong năm: Lựa chọn hàng đầu của chúng tôi!</a></h4>
        <p class="mb-2">Khám phá thế giới công nghệ tiên tiến với bài đăng trên blog mới nhất của chúng tôi, nơi chúng tôi nêu bật
            năm tiện ích thiết yếu. <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc thêm</a></span>
        </p>
      </div>
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item2.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Thế giới hấp dẫn của khoa học viễn tưởng</a></h4>
        <p class="mb-2">Khám phá sự giao thoa giữa công nghệ và tính bền vững trong bài đăng blog mới nhất của chúng tôi. Tìm hiểu về <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc thêm</a></span> </p>
      </div>
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item3.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Tìm thấy tình yêu trong những trang sách</a></h4>
        <p class="mb-2">Hãy đón đầu xu hướng với góc nhìn sâu sắc của chúng tôi về bối cảnh phát triển nhanh chóng của
            công nghệ đeo được. <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc thêm</a></span>
        </p>
      </div>
      <div class="col-md-3 posts mb-4">
        <img src="assetClient/images/post-item4.jpg" alt="post image" class="img-fluid rounded-3">
        <a href="blog.html" class="fs-6 text-primary">Sách</a>
        <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Đọc sách để có sức khỏe tinh thần: Sách có thể chữa lành và truyền cảm hứng như thế nào</a></h4>
        <p class="mb-2">Trong môi trường làm việc từ xa ngày nay, năng suất là chìa khóa. Khám phá các ứng dụng và công cụ hàng đầu
            có thể giúp bạn duy trì <span><a class="text-decoration-underline text-black-50" href="single-post.html">Đọc thêm</a></span>
        </p>
      </div>
    </div>
  </div>
</section>

@endsection
