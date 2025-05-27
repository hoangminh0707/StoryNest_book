<section id="contact-section" class="contact-area section-padding pt-0">
  <div class="container">

     <div class="row">
            <div class="col-12"> <!-- section title start -->
                <div class="section-title text-center">
                    <h2 class="title">Liên hệ với chúng tôi</h2>
                    <p class="sub-title">Hãy cho chúng tôi biết bạn đang cần gì!</p>
                </div> <!-- section title end -->
            </div>
      </div>

    <div class="row">
      {{-- Form liên hệ --}}
      <div class="col-lg-6">
       

        <form action="{{ route('contact.send') }}" method="POST">
          @csrf
          <div class="row gy-3">
            <div class="col-md-6">
              <input name="name" class="form-control" placeholder="Họ và tên *" type="text" value="{{ old('name') }}">
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <input name="phone" class="form-control" placeholder="Số điện thoại *" type="text" value="{{ old('phone') }}">
              @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <input name="email" class="form-control" placeholder="Email *" type="email" value="{{ old('email') }}">
              @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-md-6">
              <input name="subject" class="form-control" placeholder="Tiêu đề *" type="text" value="{{ old('subject') }}">
              @error('subject') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-12">
              <textarea name="message" class="form-control" placeholder="Nội dung *" rows="5">{{ old('message') }}</textarea>
              @error('message') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-sqr">Gửi</button>
            </div>
          </div>
        </form>
      </div>

      {{-- Thông tin liên hệ --}}
      <div class="col-lg-6">
        <h4 class="contact-title">Thông tin liên hệ</h4>
        <p>Hãy liên hệ với chúng tôi nếu bạn có thắc mắc hoặc cần hỗ trợ.</p>
        <ul class="list-unstyled">
          <li><i class="fa fa-map-marker"></i> 1 Cầu giấy, Hà Nội</li>
          <li><i class="fa fa-envelope-o"></i> storynest@gmail.com</li>
          <li><i class="fa fa-phone"></i> Hotline: 0123456789</li>
        </ul>
        <h6>Thời gian làm việc</h6>
        <p><span>Thứ 2 – Thứ 7:</span> 08:00 – 22:00</p>
      </div>
    </div>
  </div>
</section>


@if ( $errors->has('message'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const section = document.getElementById('contact-section');
    if (section) {
      section.scrollIntoView({ behavior: 'smooth' });
    }
  });
</script>
@endif

