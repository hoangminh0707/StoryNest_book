@extends('client.layouts.app')

@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="breadcrumb-wrap">
          <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
              <li class="breadcrumb-item active" aria-current="page">About us</li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- breadcrumb area end -->

<!-- about us area start -->
<section class="about-us section-padding">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-5">
        <div class="about-thumb">
          <img src="{{ asset('assetsClient/img/about/Banner-Sach-Thieu-Nhi.jpg') }}" alt="about thumb">

        </div>
      </div>
      <div class="col-lg-7">
        <div class="about-content">
          <h2 class="about-title">Hiệu sách tốt nhất mọi thời đại</h2>
          <h5 class="about-sub-title">
            Thật dễ để tìm thấy một cái gì đó nhanh chóng. Một cuốn sách, một bộ phim, một thông tin,
            một cảm xúc vui buồn hay sợ hãi, hay cả một mối quan hệ. Nhưng điều gì nhanh đến thì cũng rất dễ rời đi,
            và nhanh chóng chưa bao giờ gần với ” bình yên”.
          </h5>
          <p>Một cuốn sách đọc chậm rãi, sẽ được nhớ lâu hơn là một đoạn phim speed up.</p>
          <p>Một không gian yên tĩnh khiến
            bạn để tâm đến điều bạn thực sự cần hơn, một chút yên bình nổi bật giữa sự náo nhiệt.</p>
          <a href="{{ url('/shop') }}" class="btn btn-primary px-4 py-2">Khám phá cửa hàng</a>

        </div>
      </div>
    </div>
</section>
<!-- about us area end -->

<!-- choosing area start -->
<div class="choosing-area section-padding pt-0">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title text-center">
          <h2 class="title">Tại sao chọn chúng tôi</h2>
          <p>Cuộc sống đầy thử thách, nơi mọi người tự do tìm kiếm và phát triển bản thân.</p>
        </div>
      </div>
    </div>
    <div class="row mbn-30">
      <div class="col-lg-4 col-md-4">
        <div class="single-choose-item text-center mb-30">
          <i class="fa fa-globe"></i>
          <h4>Miễn phí vận chuyển</h4>
          <p>StoryNet-Book cung cấp dịch vụ vận chuyển miễn phí cho tất cả các đơn hàng, giúp bạn dễ dàng sở hữu những cuốn sách yêu thích mà không lo về chi phí giao hàng.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="single-choose-item text-center mb-30">
          <i class="fa fa-plane"></i>
          <h4>Giao hàng nhanh chóng</h4>
          <p>StoryNet-Book cam kết giao sách nhanh chóng, giúp bạn nhanh chóng nhận được những cuốn sách yêu thích và tiếp cận tri thức mọi lúc, mọi nơi.</p>

        </div>
      </div>
      <div class="col-lg-4 col-md-4">
        <div class="single-choose-item text-center mb-30">
          <i class="fa fa-comments"></i>
          <h4>Hỗ trợ khách hàng</h4>
          <p>StoryNet-Book luôn sẵn sàng hỗ trợ bạn trong suốt quá trình mua sắm, cam kết mang lại dịch vụ chăm sóc khách hàng tận tâm và nhanh chóng.</p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- choosing area end -->

<!-- testimonial area start -->
<section class="testimonial-area section-padding bg-img" data-bg="{{ asset('assetsClient/img/banner/1.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <!-- section title start -->
        <div class="section-title text-center">
          <h2 class="title">Nhận xét từ khách hàng</h2>
          <p class="sub-title">Những lời khen từ khách hàng đã tin dùng StoryNet-Book</p>
        </div>
        <!-- section title start -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="testimonial-thumb-wrapper">
          <div class="testimonial-thumb-carousel">
            <div class="testimonial-thumb">
              <img src="{{ asset('assetsClient/img/testimonial/testimonial-1.png') }}" alt="testimonial-thumb">
            </div>
            <div class="testimonial-thumb">
              <img src="{{ asset('assetsClient/img/testimonial/testimonial-2.png') }}" alt="testimonial-thumb">
            </div>
            <div class="testimonial-thumb">
              <img src="{{ asset('assetsClient/img/testimonial/testimonial-3.png') }}" alt="testimonial-thumb">
            </div>
            <div class="testimonial-thumb">
              <img src="{{ asset('assetsClient/img/testimonial/testimonial-2.png') }}" alt="testimonial-thumb">
            </div>
          </div>
        </div>
        <div class="testimonial-content-wrapper">
          <div class="testimonial-content-carousel">
            <div class="testimonial-content">
              <p class="testimonial-text">"StoryNet-Book là một nơi tuyệt vời để tìm kiếm sách. Giao diện dễ sử dụng và dịch vụ giao hàng rất nhanh chóng!"</p>
              <div class="ratings">
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
              </div>
              <h5 class="customer-name">Nguyễn Văn A</h5>
            </div>
            <div class="testimonial-content">
              <p class="testimonial-text">"Dịch vụ hỗ trợ khách hàng của StoryNet-Book thật tuyệt vời. Tôi luôn nhận được sự giúp đỡ kịp thời khi cần thiết."</p>
              <div class="ratings">
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
              </div>
              <h5 class="testimonial-author">Nguyễn Thị B</h5>
            </div>
            <div class="testimonial-content">
              <p class="testimonial-text">"Tôi đã tìm thấy rất nhiều cuốn sách yêu thích tại StoryNet-Book. Chất lượng sách rất tốt và giá cả hợp lý."</p>
              <div class="ratings">
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
              </div>
              <h5 class="testimonial-author">Nguyễn Thị C</h5>
            </div>
            <div class="testimonial-content">
              <p class="testimonial-text">"Thật tuyệt vời khi biết rằng tôi có thể đặt mua sách mọi lúc mọi nơi và được hỗ trợ 24/7!"</p>
              <div class="ratings">
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
                <span><i class="fa fa-star-o"></i></span>
              </div>
              <h5 class="testimonial-author">Nguyễn Văn A</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- testimonial area end -->

<!-- team area start -->
<div class="team-area section-padding">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="section-title text-center">
          <h2 class="title">Đội ngũ của chúng tôi</h2>
          <p>Chúng tôi là những người đam mê sách, luôn nỗ lực mang đến cho bạn những trải nghiệm tuyệt vời nhất khi mua sắm tại StoryNet-Book.</p>
        </div>
      </div>
    </div>
    <div class="row mbn-30">
      <!-- Thành viên 1 -->
      <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
        <div class="team-member text-center">
          <div class="team-thumb">
            <img src="{{ asset('assetsClient/img/about/quan.jpg') }}" alt="" class="img-fluid">
            <div class="team-social">
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-linkedin"></i></a>
              <a href="#"><i class="fa fa-google-plus"></i></a>
            </div>
          </div>
          <div class="team-content">
            <h6 class="team-member-name">Nguyễn Hồng Quân</h6>
            <p>Nhà thiết kế</p>
          </div>
        </div>
      </div> <!-- end single team member -->

      <!-- Thành viên 2 -->
      <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
        <div class="team-member text-center">
          <div class="team-thumb">
            <img src="{{ asset('assetsClient/img/about/minh.jpg') }}" alt="" class="img-fluid">
            <div class="team-social">
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-linkedin"></i></a>
              <a href="#"><i class="fa fa-google-plus"></i></a>
            </div>
          </div>
          <div class="team-content">
            <h6 class="team-member-name">Oliver Bastin</h6>
            <p>Chuyên gia Marketing</p>
          </div>
        </div>
      </div> <!-- end single team member -->

      <!-- Thành viên 3 -->
      <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
        <div class="team-member text-center">
          <div class="team-thumb">
            <img src="{{ asset('assetsClient/img/about/duong.jpg') }}" alt="" class="img-fluid">
            <div class="team-social">
              <a href="#"><i class="fa fa-facebook"></i></a>
              <a href="#"><i class="fa fa-twitter"></i></a>
              <a href="#"><i class="fa fa-linkedin"></i></a>
              <a href="#"><i class="fa fa-google-plus"></i></a>
            </div>
          </div>
          <div class="team-content">
            <h6 class="team-member-name">Erik Jonson</h6>
            <p>Điều hành</p>
          </div>
        </div>
      </div> <!-- end single team member -->

    </div> <!-- end row -->
  </div> <!-- end container -->
</div> <!-- end team-area -->

<!-- team area end -->

@endsection
<style>
  .single-choose-item {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    /* Thêm hiệu ứng mượt mà */
  }

  .single-choose-item:hover {
    transform: translateY(-10px);
    /* Di chuyển phần tử lên trên khi hover */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    /* Thêm bóng đổ khi hover */
  }

  .single-choose-item:hover i {
    color: #ff6600;
    /* Thay đổi màu icon khi hover */
  }

  .single-choose-item:hover h4 {
    color: #ff6600;
    /* Thay đổi màu tiêu đề khi hover */
  }
</style>