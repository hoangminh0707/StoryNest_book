
<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

<section id="billboard" class="position-relative d-flex align-items-center py-5 bg-light-gray"
  style="background-image: url(assetClient/images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 800px;">
  <div class="position-absolute end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next main-slider-button-next">
    <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
      <use xlink:href="#alt-arrow-right-outline"></use>
    </svg>
  </div>
  <div class="position-absolute start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev main-slider-button-prev">
    <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
      <use xlink:href="#alt-arrow-left-outline"></use>
    </svg>
  </div>
  <div class="swiper main-swiper">
    <div class="swiper-wrapper d-flex align-items-center">
      <div class="swiper-slide">
        <div class="container">
          <div class="row d-flex flex-column-reverse flex-md-row align-items-center">
            <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
              <div class="banner-content">
                <h2>The Fine Print Book Collection</h2>
                <p>Best Offer Save 30%. Grab it now!</p>
                <a href="shop.html" class="btn mt-3">Shop Collection</a>
              </div>
            </div>
            <div class="col-md-6 text-center">
              <div class="image-holder">
                <img src="assetClient/images/banner-image2.png" class="img-fluid" alt="banner">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="container">
          <div class="row d-flex flex-column-reverse flex-md-row align-items-center">
            <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
              <div class="banner-content">
                <h2>How Innovation works</h2>
                <p>Discount available. Grab it now!</p>
                <a href="shop.html" class="btn mt-3">Shop Product</a>
              </div>
            </div>
            <div class="col-md-6 text-center">
              <div class="image-holder">
                <img src="assetClient/images/banner-image1.png" class="img-fluid" alt="banner">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-slide">
        <div class="container">
          <div class="row d-flex flex-column-reverse flex-md-row align-items-center">
            <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
              <div class="banner-content">
                <h2>Your Heart is the Sea</h2>
                <p>Limited stocks available. Grab it now!</p>
                <a href="shop.html" class="btn mt-3">Shop Collection</a>
              </div>
            </div>
            <div class="col-md-6 text-center">
              <div class="image-holder">
                <img src="assetClient/images/banner-image.png" class="img-fluid" alt="banner">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="company-services" class="padding-large pb-0">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <svg class="cart-outline">
              <use xlink:href="#cart-outline" />
            </svg>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Giao hàng miễn phí</h4>
            <p>Miễn phí giao hàng

                .</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <svg class="quality">
              <use xlink:href="#quality" />
            </svg>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Đảm bảo chất lượng</h4>
            <p>Chất lượng sản phẩm cao .</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <svg class="price-tag">
              <use xlink:href="#price-tag" />
            </svg>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Ưu đãi hằng ngày</h4>
            <p>Ưu đãi với giá hấp dẫn.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
        <div class="icon-box d-flex">
          <div class="icon-box-icon pe-3 pb-3">
            <svg class="shield-plus">
              <use xlink:href="#shield-plus" />
            </svg>
          </div>
          <div class="icon-box-content">
            <h4 class="card-title mb-1 text-capitalize text-dark">Thanh toán an toàn 100%</h4>
            <p>Bảo mật thanh toán</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="best-selling-items" class="position-relative padding-large ">
  <div class="container">
    <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
      <h3 class="d-flex align-items-center">Các mặt hàng bán chạy nhất</h3>
      <a href="shop.html" class="btn">Xem tất cả</a>
    </div>
    <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next product-slider-button-next">
      <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
        <use xlink:href="#alt-arrow-right-outline"></use>
      </svg>
    </div>
    <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev product-slider-button-prev">
      <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
        <use xlink:href="#alt-arrow-left-outline"></use>
      </svg>
    </div>
    <div class="swiper product-swiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="card position-relative p-4 border rounded-3">
            <div class="position-absolute">
              <p class="bg-primary py-1 px-3 fs-6 text-white rounded-2">10% off</p>
            </div>
            <img src="assetClient/images/product-item1.png" class="img-fluid shadow-sm" alt="product item">
            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">House of Sky Breath</a></h6>
            <div class="review-content d-flex">
              <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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
            <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
              <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Tooltip on top">
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
        <div class="swiper-slide">
          <div class="card position-relative p-4 border rounded-3">
            <img src="assetClient/images/product-item2.png" class="img-fluid shadow-sm" alt="product item">
            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Heartland Stars</a></h6>
            <div class="review-content d-flex">
              <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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

            <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
              <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Tooltip on top">
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
        <div class="swiper-slide">
          <div class="card position-relative p-4 border rounded-3">
            <img src="assetClient/images/product-item3.png" class="img-fluid shadow-sm" alt="product item">
            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">Heavenly Bodies</a></h6>
            <div class="review-content d-flex">
              <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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

            <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
              <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Tooltip on top">
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
        <div class="swiper-slide">
          <div class="card position-relative p-4 border rounded-3">
            <div class="position-absolute">
              <p class="bg-primary py-1 px-3 fs-6 text-white rounded-2">10% off</p>
            </div>
            <img src="assetClient/images/product-item4.png" class="img-fluid shadow-sm" alt="product item">
            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">His Saving Grace</a></h6>
            <div class="review-content d-flex">
              <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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

            <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
              <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Tooltip on top">
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
        <div class="swiper-slide">
          <div class="card position-relative p-4 border rounded-3">
            <img src="assetClient/images/product-item5.png" class="img-fluid shadow-sm" alt="product item">
            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">My Dearest Darkest</a></h6>
            <div class="review-content d-flex">
              <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

              <div class="rating text-warning d-flex align-items-center d-flex align-items-center">
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

            <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
              <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Tooltip on top">
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
        <div class="swiper-slide">
          <div class="card position-relative p-4 border rounded-3">
            <img src="assetClient/images/product-item6.png" class="img-fluid shadow-sm" alt="product item">
            <h6 class="mt-4 mb-0 fw-bold"><a href="single-product.html">The Story of Success</a></h6>
            <div class="review-content d-flex">
              <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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

            <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
            <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
              <button type="button" href="#" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-title="Tooltip on top">
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

      </div>
    </div>
  </div>
</section>

<section id="limited-offer" class="padding-large"
  style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 800px;">
  <div class="container">
    <div class="row d-flex align-items-center">
      <div class="col-md-6 text-center">
        <div class="image-holder">
          <img src="assetClient/images/banner-image3.png" class="img-fluid" alt="banner">
        </div>
      </div>
      <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
        <h2>30% Discount on all items. Hurry Up !!!</h2>
        <div id="countdown-clock" class="text-dark d-flex align-items-center my-3">
          <div class="time d-grid pe-3">
            <span class="days fs-1 fw-normal"></span>
            <small>Days</small>
          </div>
          <span class="fs-1 text-primary">:</span>
          <div class="time d-grid pe-3 ps-3">
            <span class="hours fs-1 fw-normal"></span>
            <small>Hrs</small>
          </div>
          <span class="fs-1 text-primary">:</span>
          <div class="time d-grid pe-3 ps-3">
            <span class="minutes fs-1 fw-normal"></span>
            <small>Min</small>
          </div>
          <span class="fs-1 text-primary">:</span>
          <div class="time d-grid ps-3">
            <span class="seconds fs-1 fw-normal"></span>
            <small>Sec</small>
          </div>
        </div>
        <a href="shop.html" class="btn mt-3">Shop Collection</a>
      </div>
    </div>
  </div>
  </div>
</section>

<section id="items-listing" class="padding-large">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="featured border rounded-3 p-4">
          <div class="section-title overflow-hidden mb-5 mt-2">
            <h3 class="d-flex flex-column mb-0">Nổi bật</h3>
          </div>
          <div class="items-lists">
            <div class="item d-flex">
              <img src="assetClient/images/product-item2.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Echoes of the Ancients</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
            <hr class="gray-400">
            <div class="item d-flex">
              <img src="assetClient/images/product-item1.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">The Midnight Garden</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
            <hr>
            <div class="item d-flex">
              <img src="assetClient/images/product-item3.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Shadow of the Serpent</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>

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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="latest-items border rounded-3 p-4">
          <div class="section-title overflow-hidden mb-5 mt-2">
            <h3 class="d-flex flex-column mb-0">Các mục mới nhất</h3>
          </div>
          <div class="items-lists">
            <div class="item d-flex">
              <img src="assetClient/images/product-item4.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Whispering Winds</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
            <hr class="gray-400">
            <div class="item d-flex">
              <img src="assetClient/images/product-item5.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">The Forgotten Realm</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
            <hr>
            <div class="item d-flex">
              <img src="assetClient/images/product-item6.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Moonlit Secrets</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="best-reviewed border rounded-3 p-4">
          <div class="section-title overflow-hidden mb-5 mt-2">
            <h3 class="d-flex flex-column mb-0">Được đánh giá tốt nhất</h3>
          </div>
          <div class="items-lists">
            <div class="item d-flex">
              <img src="assetClient/images/product-item7.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">The Crystal Key</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
            <hr class="gray-400">
            <div class="item d-flex">
              <img src="assetClient/images/product-item8.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Starlight Sonata</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
            <hr>
            <div class="item d-flex">
              <img src="assetClient/images/product-item9.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Tales of the Enchanted Forest</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5">$870</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4 mb-lg-0 col-lg-3">
        <div class="on-sale border rounded-3 p-4">
          <div class="section-title overflow-hidden mb-5 mt-2">
            <h3 class="d-flex flex-column mb-0">Đang bán</h3>
          </div>
          <div class="items-lists">
            <div class="item d-flex">
              <img src="assetClient/images/product-item10.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">The Phoenix Chronicles</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5"><s class="text-black-50">$1666</s>
                  $999</span>
              </div>
            </div>
            <hr class="gray-400">
            <div class="item d-flex">
              <img src="assetClient/images/product-item11.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Dreams of Avalon</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5"><s class="text-black-50">$500</s>
                  $410</span>
              </div>
            </div>
            <hr>
            <div class="item d-flex">
              <img src="assetClient/images/product-item12.png" class="img-fluid shadow-sm" alt="product item">
              <div class="item-content ms-3">
                <h6 class="mb-0 fw-bold"><a href="single-product.html">Legends of the Dragon Isles</a></h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50">Lauren Asher</p>
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
                <span class="price text-primary fw-bold mb-2 fs-5"><s class="text-black-50">$600</s>
                  $500</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="categories" class="padding-large pt-0">
  <div class="container">
    <div class="section-title overflow-hidden mb-4">
      <h3 class="d-flex align-items-center">Thể loại</h3>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-4 border-0 rounded-3 position-relative">
          <a href="shop.html">
            <img src="assetClient/images/category1.jpg" class="img-fluid rounded-3" alt="cart item">
            <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a href="shop.html"
                class="text-white">Lãng mạn</a></h6>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center mb-4 border-0 rounded-3">
          <a href="shop.html">
            <img src="assetClient/images/category2.jpg" class="img-fluid rounded-3" alt="cart item">
            <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a href="shop.html"
                class="text-white"> Phong cách sống</a></h6>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center mb-4 border-0 rounded-3">
          <a href="shop.html">
            <img src="assetClient/images/category3.jpg" class="img-fluid rounded-3" alt="cart item">
            <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3"><a href="shop.html"
                class="text-white">Công thức</a></h6>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

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

<section id="instagram">
  <div class="container">
    <div class="text-center mb-4">
      <h3>Instagram</h3>
    </div>
    <div class="row">
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
          <a href="https://templatesjungle.com/" class="image-link position-relative">
            <div class="icon-overlay position-absolute d-flex justify-content-center">
              <svg class="instagram">
                <use xlink:href="#instagram"></use>
              </svg>
            </div>
            <img src="assetClient/images/insta-item1.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
          </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
          <a href="https://templatesjungle.com/" class="image-link position-relative">
            <div class="icon-overlay position-absolute d-flex justify-content-center">
              <svg class="instagram">
                <use xlink:href="#instagram"></use>
              </svg>
            </div>
            <img src="assetClient/images/insta-item2.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
          </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
          <a href="https://templatesjungle.com/" class="image-link position-relative">
            <div class="icon-overlay position-absolute d-flex justify-content-center">
              <svg class="instagram">
                <use xlink:href="#instagram"></use>
              </svg>
            </div>
            <img src="assetClient/images/insta-item3.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
          </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
          <a href="https://templatesjungle.com/" class="image-link position-relative">
            <div class="icon-overlay position-absolute d-flex justify-content-center">
              <svg class="instagram">
                <use xlink:href="#instagram"></use>
              </svg>
            </div>
            <img src="assetClient/images/insta-item4.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
          </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
          <a href="https://templatesjungle.com/" class="image-link position-relative">
            <div class="icon-overlay position-absolute d-flex justify-content-center">
              <svg class="instagram">
                <use xlink:href="#instagram"></use>
              </svg>
            </div>
            <img src="assetClient/images/insta-item5.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
          </a>
        </figure>
      </div>
      <div class="col-md-2">
        <figure class="instagram-item position-relative rounded-3">
          <a href="https://templatesjungle.com/" class="image-link position-relative">
            <div class="icon-overlay position-absolute d-flex justify-content-center">
              <svg class="instagram">
                <use xlink:href="#instagram"></use>
              </svg>
            </div>
            <img src="assetClient/images/insta-item6.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
          </a>
        </figure>
      </div>
    </div>
  </div>
</section>

@endsection
