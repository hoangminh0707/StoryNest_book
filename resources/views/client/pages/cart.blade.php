
<?php
?>

@extends('client.layouts.app')
@section('title', 'Dashboards')

@section('content')

<section class="hero-section position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>Cart</h1>
            <div class="breadcrumbs">
              <span class="item text-decoration-underline">Cart</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="cart padding-large">
    <div class="container">
      <div class="row">
        <div class="cart-table">
          <div class="cart-header border-bottom border-top">
            <div class="row d-flex text-capitalize">
              <h4 class="col-lg-4 py-3 m-0">Sản Phẩm</h4>
              <h4 class="col-lg-3 py-3 m-0">Số Lượng</h4>
              <h4 class="col-lg-4 py-3 m-0">Tổng Giá</h4>
            </div>
          </div>

          <div class="cart-item border-bottom padding-small">
            <div class="row align-items-center">
              <div class="col-lg-4 col-md-3">
                <div class="cart-info d-flex gap-2 flex-wrap align-items-center">
                  <div class="col-lg-5">
                    <div class="card-image">
                      <img src="assetClient/images/cart-item1.png" alt="cart-img" class="img-fluid border rounded-3">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card-detail">
                      <h5 class="mt-2"><a href="single-product.html">The Emerald Crown</a></h5>
                      <div class="card-price">
                        <span class="price text-primary fw-light" data-currency-usd="$2000.00">$2000.00</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-7">
                <div class="row d-flex">
                  <div class="col-md-6">
                    <div class="product-quantity my-2 my-2">
                      <div class="input-group product-qty align-items-center" style="max-width: 150px;">
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-left-minus" data-type="minus" data-field="">
                            <svg width="16" height="16">
                              <use xlink:href="#minus"></use>
                            </svg>
                          </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control bg-white shadow border rounded-3 py-2 mx-2 input-number text-center" value="1" min="1" max="100" required="">
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-right-plus" data-type="plus" data-field="">
                            <svg width="16" height="16">
                              <use xlink:href="#plus"></use>
                            </svg>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="total-price">
                      <span class="money fs-2 fw-light text-primary">$2000.00</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-2">
                <div class="cart-cross-outline">
                  <a href="#">
                    <svg class="cart-cross-outline" width="38" height="38">
                      <use xlink:href="#cart-cross-outline"></use>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="cart-item border-bottom padding-small">
            <div class="row align-items-center">
              <div class="col-lg-4 col-md-3">
                <div class="cart-info d-flex gap-2 flex-wrap align-items-center">
                  <div class="col-lg-5">
                    <div class="card-image">
                      <img src="assetClient/images/cart-item2.png" alt="cart-img" class="img-fluid border rounded-3">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="card-detail">
                      <h5 class="mt-2"><a href="single-product.html">The Last Enchantment</a></h5>
                      <div class="card-price">
                        <span class="price text-primary fw-light" data-currency-usd="$2000.00">$400.00</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-7">
                <div class="row d-flex">
                  <div class="col-lg-6">
                    <div class="product-quantity my-2">
                      <div class="input-group product-qty align-items-center" style="max-width: 150px;">
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-left-minus" data-type="minus" data-field="">
                            <svg width="16" height="16">
                              <use xlink:href="#minus"></use>
                            </svg>
                          </button>
                        </span>
                        <input type="text" id="quantity" name="quantity" class="form-control bg-white shadow border rounded-3 py-2 mx-2 input-number text-center" value="1" min="1" max="100" required="">
                        <span class="input-group-btn">
                          <button type="button" class="bg-white shadow border rounded-3 fw-light quantity-right-plus" data-type="plus" data-field="">
                            <svg width="16" height="16">
                              <use xlink:href="#plus"></use>
                            </svg>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="total-price">
                      <span class="money fs-2 fw-light text-primary">$400.00</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-2">
                <div class="cart-cross-outline">
                  <a href="#">
                    <svg class="cart-cross-outline" width="38" height="38">
                      <use xlink:href="#cart-cross-outline"></use>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="cart-totals padding-medium pb-0">
          <h3 class="mb-3">Tổng số giỏ hàng</h3>
          <div class="total-price pb-3">
            <table cellspacing="0" class="table text-capitalize">
              <tbody>
                <tr class="subtotal pt-2 pb-2 border-top border-bottom">
                  <th>Tổng giá</th>
                  <td data-title="Subtotal">
                    <span class="price-amount amount text-primary ps-5 fw-light">
                      <bdi>
                        <span class="price-currency-symbol">$</span>2,400.00
                      </bdi>
                    </span>
                  </td>
                </tr>
                <tr class="order-total pt-2 pb-2 border-bottom">
                  <th>Tổng cộng</th>
                  <td data-title="Total">
                    <span class="price-amount amount text-primary ps-5 fw-light">
                      <bdi>
                        <span class="price-currency-symbol">$</span>2,400.00</bdi>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="button-wrap d-flex flex-wrap gap-3">
            <button class="btn">Cập nhật giỏ hàng</button>
            <button class="btn">Tiếp tục mua sắm</button>
            <button class="btn">Tiến hành thanh toán</button>
          </div>
        </div>
      </div>
    </div>
  <section class="hero-section position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 400px;">
    <div class="hero-content">
      <div class="container">
        <div class="row">
          <div class="text-center">
            <h1>Cart</h1>
            <div class="breadcrumbs">
              <span class="item">
                <a href="index.html">Home &gt; </a>
              </span>
              <span class="item text-decoration-underline">Cart</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section></section>

  <section id="customers-reviews" class="position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 600px;">
    <div class="container offset-md-3 col-md-6 ">
      <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next testimonial-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-0c15982eb983e2c8" aria-disabled="false">
        <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-right-outline"></use>
        </svg>
      </div>
      <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev testimonial-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-0c15982eb983e2c8" aria-disabled="true">
        <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-left-outline"></use>
        </svg>
      </div>
      <div class="section-title mb-4 text-center">
        <h3 class="mb-4">Customers reviews</h3>
      </div>
      <div class="swiper testimonial-swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
        <div class="swiper-wrapper" id="swiper-wrapper-0c15982eb983e2c8" aria-live="polite">
          <div class="swiper-slide swiper-slide-active" role="group" aria-label="1 / 5" style="width: 736px; margin-right: 20px;">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>"I stumbled upon this bookstore while visiting the city, and it instantly became my favorite spot. The cozy atmosphere, friendly staff, and wide selection of books make every visit a delight!"</blockquote>
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
          <div class="swiper-slide swiper-slide-next" role="group" aria-label="2 / 5" style="width: 736px; margin-right: 20px;">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>"As an avid reader, I'm always on the lookout for new releases, and this bookstore never disappoints. They always have the latest titles, and their recommendations have introduced me to some incredible reads!"</blockquote>
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
          <div class="swiper-slide" role="group" aria-label="3 / 5" style="width: 736px; margin-right: 20px;">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>"I ordered a few books online from this store, and I was impressed by the quick delivery and careful packaging. It's clear that they prioritize customer satisfaction, and I'll definitely be shopping here again!"</blockquote>
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
          <div class="swiper-slide" role="group" aria-label="4 / 5" style="width: 736px; margin-right: 20px;">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>“I stumbled upon this tech store while searching for a new laptop, and I couldn't be happier
                with my experience! The staff was incredibly knowledgeable and guided me through the process of choosing
                the perfect device for my needs. Highly recommended!”</blockquote>
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
          <div class="swiper-slide" role="group" aria-label="5 / 5" style="width: 736px; margin-right: 20px;">
            <div class="card position-relative text-left p-5 border rounded-3">
              <blockquote>“I stumbled upon this tech store while searching for a new laptop, and I couldn't be happier
                with my experience! The staff was incredibly knowledgeable and guided me through the process of choosing
                the perfect device for my needs. Highly recommended!”</blockquote>
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
      <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
    </div>
  </section>


  <section id="latest-posts" class="padding-large">
    <div class="container">
      <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
        <h3 class="d-flex align-items-center">Latest posts</h3>
        <a href="shop.html" class="btn">View All</a>
      </div>
      <div class="row">
        <div class="col-md-3 posts mb-4">
          <img src="assetClient/images/post-item1.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">10 Must-Read Books of the Year: Our Top Picks!</a></h4>
          <p class="mb-2">Dive into the world of cutting-edge technology with our latest blog post, where we highlight
            five essential gadg <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span>
          </p>
        </div>
        <div class="col-md-3 posts mb-4">
          <img src="assetClient/images/post-item2.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">The Fascinating Realm of Science Fiction</a></h4>
          <p class="mb-2">Explore the intersection of technology and sustainability in our latest blog post. Learn about
            the innovative <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span> </p>
        </div>
        <div class="col-md-3 posts mb-4">
          <img src="assetClient/images/post-item3.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Finding Love in the Pages of a Book</a></h4>
          <p class="mb-2">Stay ahead of the curve with our insightful look into the rapidly evolving landscape of
            wearable technology. <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span>
          </p>
        </div>
        <div class="col-md-3 posts mb-4">
          <img src="assetClient/images/post-item4.jpg" alt="post image" class="img-fluid rounded-3">
          <a href="blog.html" class="fs-6 text-primary">Books</a>
          <h4 class="card-title mb-2 text-capitalize text-dark"><a href="single-post.html">Reading for Mental Health: How Books Can Heal and Inspire</a></h4>
          <p class="mb-2">In today's remote work environment, productivity is key. Discover the top apps and tools that
            can help you stay <span><a class="text-decoration-underline text-black-50" href="single-post.html">Read More</a></span>
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
