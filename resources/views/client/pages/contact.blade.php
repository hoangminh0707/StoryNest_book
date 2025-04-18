
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
            <h1>Contact</h1>
            <div class="breadcrumbs">

              <span class="item text-decoration-underline">Contact</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <div class="contact-us padding-large">
    <div class="container">
      <div class="row">
        <div class="contact-info col-lg-6 pb-3">
          <h3>Thông tin liên lạc</h3>
          <p class="mb-5">Tortor dignissim convallis aenean et tortor at risus viverra adipiscing.</p>
          <div class="page-content d-flex flex-wrap">
            <div class="col-lg-6 col-sm-12">
              <div class="content-box text-dark pe-4 mb-5">
                <h5 class="fw-bold">Văn phòng</h5>
                <div class="contact-address pt-3">
                  <p>730 Glenstone Ave 65802, Springfield, US</p>
                </div>
                <div class="contact-number">
                  <p>
                    <a href="#">+123 987 321</a>
                  </p>
                  <p>
                    <a href="#">+123 123 654</a>
                  </p>
                </div>
                <div class="email-address">
                  <p>
                    <a href="#">info@yourinfo.com</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12">
              <div class="content-box">
                <h5 class="fw-bold">Sự quản lý</h5>
                <div class="contact-address pt-3">
                  <p>730 Glenstone Ave 65802, Springfield, US</p>
                </div>
                <div class="contact-number">
                  <p>
                    <a href="#">+123 987 321</a>
                  </p>
                  <p>
                    <a href="#">+123 123 654</a>
                  </p>
                </div>
                <div class="email-address">
                  <p>
                    <a href="#">info@yourinfo.com</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="inquiry-item col-lg-6">
          <h3>Bạn có thắc mắc gì không?</h3>
          <p class="mb-5">Sử dụng mẫu dưới đây để liên hệ với chúng tôi.</p>

          <form id="form" class="d-flex gap-3 flex-wrap">
            <div class="w-100 d-flex gap-3">
              <div class="w-50">
                <input type="text" name="name" placeholder="Viết tên của bạn ở đây*" class="form-control w-100">
              </div>
              <div class="w-50">
                <input type="text" name="email" placeholder="Viết email của bạn ở đây*" class="form-control w-100">
              </div>
            </div>
            <div class="w-100">
              <input type="text" name="phone" placeholder="Số điện thoại" class="form-control w-100">
            </div>
            <div class="w-100">
              <input type="text" name="subject" placeholder="Viết chủ đề của bạn ở đây" class="form-control w-100">
            </div>
            <div class="w-100">
              <textarea placeholder="Viết tin nhắn của bạn ở đây *" class="form-control w-100"></textarea>
            </div>
            <button type="submit" name="submit" class="btn my-3">Gửi</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <section id="customers-reviews" class="position-relative padding-large" style="background-image: url(assetClient/images/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 600px;">
    <div class="container offset-md-3 col-md-6 ">
      <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next testimonial-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-1f864c8507827d5f" aria-disabled="false">
        <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-right-outline"></use>
        </svg>
      </div>
      <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev testimonial-button-prev swiper-button-disabled" tabindex="-1" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-1f864c8507827d5f" aria-disabled="true">
        <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-left-outline"></use>
        </svg>
      </div>
      <div class="section-title mb-4 text-center">
        <h3 class="mb-4">Customers reviews</h3>
      </div>
      <div class="swiper testimonial-swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
        <div class="swiper-wrapper" id="swiper-wrapper-1f864c8507827d5f" aria-live="polite">
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
