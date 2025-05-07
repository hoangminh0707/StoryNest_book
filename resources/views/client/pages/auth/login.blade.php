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
        <input type="email" name="email" placeholder="Nhập Email của bạn" required="">
      </div>
      <div class="single-input-item">
        <input type="password" name="password" placeholder="Nhập mật khẩu của bạn" required="">
      </div>
      <div class="single-input-item">
        <div class="login-reg-form-meta d-flex align-items-center justify-content-between">
        <div class="remember-meta">
        </div>
        <a href="#" class="forget-pwd">Forget Password?</a>
        </div>
      </div>
      <div class="single-input-item">
        <button type="submit" class="btn btn-sqr">Đăng Nhập</button>
      </div>
      </form>
    </div>

    </div>

  </section>



@endsection