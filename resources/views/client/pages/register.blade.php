

  
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


<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group py-3">
      <label class="mb-2">Name</label>
      <input type="text" name="name" placeholder="Name" class="form-control w-100 rounded-3 p-3" required>
    </div>
    <div class="form-group py-3">
      <label class="mb-2">Email address *</label>
      <input type="email" name="email" placeholder="Your Email" class="form-control w-100 rounded-3 p-3" required>
    </div>
    <div class="form-group pb-3">
      <label class="mb-2">Password *</label>
      <input type="password" name="password" placeholder="Your Password" class="form-control w-100 rounded-3 p-3" required>
    </div>
    <div class="form-group pb-3">
      <label class="mb-2">Confirm Password *</label>
      <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control w-100 rounded-3 p-3" required>
    </div>

    <div class="form-group pb-3">
        <label class="mb-2">Giới Tính</label>
        <select name="gender" class="form-control w-100 rounded-3 p-3">
            <option value="male">Nam</option>
            <option value="female">Nữ</option>
            <option value="other">Khác</option>
        </select>
      </div>

      <div class="form-group py-3">
        <label class="mb-2">Ngày Sinh </label>
        <input type="date" name="birthdate" class="form-control w-100 rounded-3 p-3" required>
      </div>

      <div class="form-group py-3">
        <label class="mb-2">Số Điện Thoại </label>
        <input type="phone" name="phone" placeholder="Nhập số điện thoại của bạn" class="form-control w-100 rounded-3 p-3" required>
      </div>

    <label class="py-3">
      <input type="checkbox" required class="d-inline">
      <span class="label-body">I agree to the <a href="#" class="fw-bold">Privacy Policy</a></span>
    </label>
    <button type="submit" class="btn btn-dark w-100 my-3">Register</button>
  </form>

    </div>
</section>

@endsection
