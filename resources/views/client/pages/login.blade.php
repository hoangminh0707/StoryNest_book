

  
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
  

  <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group py-3">
      <label class="mb-2">Username or email address *</label>
      <input type="text" name="email" placeholder="Your Email" class="form-control w-100 rounded-3 p-3" required>
    </div>
    <div class="form-group pb-3">
      <label class="mb-2">Password *</label>
      <input type="password" name="password" placeholder="Your Password" class="form-control w-100 rounded-3 p-3" required>
    </div>
    <label class="py-3">
      <input type="checkbox" name="remember" class="d-inline">
      <span class="label-body">Remember me</span>
      <span class="label-body"><a href="#" class="fw-bold">Forgot Password</a></span>
    </label>
    <button type="submit" class="btn btn-dark w-100 my-3">Login</button>
  </form>

    </div>
  </section>
  
  
  
  @endsection
  