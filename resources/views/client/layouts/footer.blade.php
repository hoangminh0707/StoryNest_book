<footer id="footer" class="bg-light pt-5 pb-4 border-top">
  <div class="container">
    <div class="row g-4">
      <!-- Cột logo & mô tả -->
      <div class="col-lg-4 col-md-6">
        <div class="footer-logo mb-3">
          <img src="https://i.ibb.co/HDdt9T0j/STORYNEST-BOOK-2.png" alt="logo" class="img-fluid" style="max-width: 180px;">
        </div>
        <p class="text-muted">StoryNest Book là website chuyên bán sách và dụng cụ học tập cho học sinh. Chúng tôi cung cấp sản phẩm chất lượng, giá hợp lý và giao hàng nhanh chóng – đồng hành cùng bạn trên hành trình học tập mỗi ngày.</p>
        <ul class="list-unstyled d-flex gap-3 mt-3">
          <li><a href="#"><svg class="facebook"><use xlink:href="#facebook" /></svg></a></li>
          <li><a href="#"><svg class="instagram"><use xlink:href="#instagram" /></svg></a></li>
          <li><a href="#"><svg class="twitter"><use xlink:href="#twitter" /></svg></a></li>
          <li><a href="#"><svg class="linkedin"><use xlink:href="#linkedin" /></svg></a></li>
          <li><a href="#"><svg class="youtube"><use xlink:href="#youtube" /></svg></a></li>
        </ul>
      </div>

      <!-- Cột liên kết nhanh -->
      <div class="col-lg-2 col-md-6">
        <h5 class="fw-bold mb-3">Liên kết nhanh</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('index') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
          <li><a href="{{ route('about') }}" class="text-decoration-none text-muted">Giới thiệu</a></li>
          <li><a href="{{ route('shop') }}" class="text-decoration-none text-muted">Cửa hàng</a></li>
          <li><a href="{{ route('blogs.index') }}" class="text-decoration-none text-muted">Blogs</a></li>
          <li><a href="{{ route('contact') }}" class="text-decoration-none text-muted">Liên hệ</a></li>
        </ul>
      </div>

      <!-- Cột trợ giúp -->
      <div class="col-lg-3 col-md-6">
        <h5 class="fw-bold mb-3">Trợ giúp & Hướng dẫn</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-decoration-none text-muted">Theo dõi đơn hàng</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Chính sách trả hàng</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Vận chuyển & Giao hàng</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Liên hệ với chúng tôi</a></li>
          <li><a href="#" class="text-decoration-none text-muted">Câu hỏi thường gặp</a></li>
        </ul>
      </div>

      <!-- Cột liên hệ -->
      <div class="col-lg-3 col-md-6">
        <h5 class="fw-bold mb-3">Liên hệ</h5>
        <p class="text-muted mb-2">Bạn có thắc mắc hoặc góp ý? Gửi về:  
          <a href="mailto:bookstorynest@gmail.com" class="text-decoration-underline">bookstorynest@gmail.com</a>
        </p>
        <p class="text-muted">Cần hỗ trợ? Gọi ngay: 
          <a href="tel:+84999999999" class="text-decoration-underline">+84 999 999 999</a>
        </p>
      </div>
    </div>
  </div>
</footer>
