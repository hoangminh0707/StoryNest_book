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


    <div class="login-reg-form-wrap sign-up-form">
      <h5>Signup Form</h5>
      <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="single-input-item">
        <input type="text" name="name" placeholder="Full Name" required>
      </div>

      <div class="single-input-item">
        <input type="email" name="email" placeholder="Enter your Email" required>
      </div>

      <div class="row">
        <div class="col-lg-6">
        <div class="single-input-item">
          <input type="password" name="password" placeholder="Enter your Password" required>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="single-input-item">
          <input type="password" name="password_confirmation" placeholder="Repeat your Password" required>
        </div>
        </div>
      </div>

      <div class="single-input-item">
        <label class="mb-2 d-block">Giới Tính</label>
        <select name="gender" class="form-control">
        <option value="male">Nam</option>
        <option value="female">Nữ</option>
        <option value="other">Khác</option>
        </select>
      </div>

      <div class="single-input-item">
        <label class="mb-2 d-block">Ngày Sinh</label>
        <input type="date" name="birthdate" class="form-control" required>
      </div>

      <div class="single-input-item">
        <label class="mb-2 d-block">Số Điện Thoại</label>
        <input type="phone" name="phone" placeholder="Nhập số điện thoại của bạn" class="form-control" required>
      </div>

      <div class="single-input-item">
        <div class="custom-control custom-checkbox">
        <input type="checkbox" name="newsletter" class="custom-control-input" id="subnewsletter">
        <label class="custom-control-label" for="subnewsletter"> I agree to the <a href="#" class="fw-bold">Privacy
          Policy</a></label>
        </div>
      </div>

      <div class="single-input-item">
        <button type="submit" class="btn btn-sqr">Register</button>
      </div>
      </form>
    </div>
    </div>
  </section>


@endsection