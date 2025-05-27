@extends('client.layouts.app')

@section('content')

<section class="auth-section container py-5">
  <div class="tabs-listing">

    <div class="login-reg-form-wrap sign-up-form">
      <h5>Đăng ký tài khoản</h5>
      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="single-input-item">
          <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}">
          @error('name')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="single-input-item">
          <input type="email" name="email" placeholder="Nhập email của bạn" value="{{ old('email') }}">
          @error('email')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="single-input-item position-relative">
              <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" class="form-control">
              <span class="toggle-password" toggle="#password" style="position:absolute; right:15px; top:50%; transform: translateY(-50%); cursor:pointer;">
                <i class="fa fa-eye"></i>
              </span>
              @error('password')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="col-lg-6">
            <div class="single-input-item position-relative">
              <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Nhập lại mật khẩu" class="form-control">
              <span class="toggle-password" toggle="#password_confirmation" style="position:absolute; right:15px; top:50%; transform: translateY(-50%); cursor:pointer;">
                <i class="fa fa-eye"></i>
              </span>
            </div>
          </div>
        </div>


        <div class="single-input-item">
          <label class="mb-2 d-block">Giới tính</label>
          <select name="gender" class="form-control">
            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
          </select>
          @error('gender')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="single-input-item">
          <label class="mb-2 d-block">Ngày sinh</label>
          <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate') }}">
          @error('birthdate')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="single-input-item">
          <label class="mb-2 d-block">Số điện thoại</label>
          <input type="text" name="phone" placeholder="Nhập số điện thoại của bạn" class="form-control" value="{{ old('phone') }}">
          @error('phone')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="single-input-item">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" name="newsletter" class="custom-control-input" id="subnewsletter" {{ old('newsletter') ? 'checked' : '' }}>
            <label class="custom-control-label" for="subnewsletter">
              Tôi đồng ý đăng kí
            </label>
          </div>
          @error('newsletter')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>

        <div class="single-input-item">
          <button type="submit" class="btn btn-sqr">Đăng ký</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function(el) {
      el.addEventListener('click', function() {
        const input = document.querySelector(this.getAttribute('toggle'));
        const icon = this.querySelector('i');
        if (input.getAttribute('type') === 'password') {
          input.setAttribute('type', 'text');
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          input.setAttribute('type', 'password');
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });
    });
  });
</script>


@endsection