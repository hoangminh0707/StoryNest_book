@extends('client.layouts.app')

@section('content')

<section class="auth-section container py-5">
  <div class="tabs-listing">

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="login-reg-form-wrap">
      <h5>Đăng Nhập</h5>
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="single-input-item">
          <input type="email" name="email" placeholder="Nhập Email của bạn" value="{{ old('email') }}">
        </div>

        <div class="single-input-item position-relative">
          <input type="password" name="password" id="password" placeholder="Nhập mật khẩu của bạn">
          <span class="toggle-password" toggle="#password" style="position:absolute; right:15px; top:50%; transform: translateY(-50%); cursor:pointer;">
            <i class="fa fa-lock"></i>
          </span>
        </div>

        <div class="single-input-item">
          <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
            <div class="remember-meta">
              <!-- checkbox ghi nhớ có thể thêm ở đây -->
            </div>
            <a href="{{ route('password.request') }}" class="forget-pwd">Quên mật khẩu?</a>
          </div>
        </div>

        <div class="single-input-item">
          <button type="submit" class="btn btn-sqr">Đăng Nhập</button>
        </div>
      </form>
    </div>

  </div>
</section>

<style>
  .toggle-password i {
    font-size: 1.2rem;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function(el) {
      el.addEventListener('click', function() {
        const input = document.querySelector(this.getAttribute('toggle'));
        const icon = this.querySelector('i');
        if (input.getAttribute('type') === 'password') {
          input.setAttribute('type', 'text');
          icon.classList.remove('fa-lock');
          icon.classList.add('fa-unlock');
        } else {
          input.setAttribute('type', 'password');
          icon.classList.remove('fa-unlock');
          icon.classList.add('fa-lock');
        }
      });
    });
  });
</script>

@endsection
