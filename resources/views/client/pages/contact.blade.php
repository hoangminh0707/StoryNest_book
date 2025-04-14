
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
              <span class="item">
                <a href="index.html">Home &gt; </a>
              </span>
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


  <section id="our-store" class="padding-large pt-0">
    <div class="container">
      <div class="row d-flex flex-wrap align-items-center">
        <div class="col-lg-6">
          <div class="image-holder mb-5">
            <img src="assetClient/images/single-image2.jpg" alt="our-store" class="img-fluid">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="locations-wrap ms-lg-5">
            <div class="display-header">
              <h3>Cửa hàng của chúng tôi</h3>
              <p class="mb-5">You can also directly buy products from our stores.</p>
            </div>
            <div class="location-content d-flex flex-wrap">
              <div class="col-lg-6 col-sm-12">
                <div class="content-box text-dark pe-4 mb-5">
                  <h5 class="fw-bold">MỸ</h5>
                  <div class="contact-address pt-3">
                    <p>730 Glenstone Ave 65802, US</p>
                  </div>
                  <div class="contact-number">
                    <p>
                      <a href="#">+123 666 777 88</a>
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
                  <h5 class="fw-bold">Pháp</h5>
                  <div class="contact-address pt-3">
                    <p>13 Rue Montmartre 75001, Paris, France</p>
                  </div>
                  <div class="contact-number">
                    <p>
                      <a href="#">+123 222 333 44</a>
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
                <div class="content-box text-dark pe-4 mb-5">
                  <h5 class="fw-bold">Canada</h5>
                  <div class="contact-address pt-3">
                    <p>730 Glenstone Ave 65802, US</p>
                  </div>
                  <div class="contact-number">
                    <p>
                      <a href="#">+123 666 777 88</a>
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
                  <h5 class="fw-bold">Trung quốc</h5>
                  <div class="contact-address pt-3">
                    <p>13 Rue Montmartre 75001, Paris, France</p>
                  </div>
                  <div class="contact-number">
                    <p>
                      <a href="#">+123 222 333 44</a>
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
