@extends('client.layouts.app')

@section('content')
<section class="auth-section container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="login-reg-form-wrap p-4 shadow rounded bg-white">
                <h4 class="text-center mb-4">Đặt lại mật khẩu</h4>


                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="single-input-item mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $email) }}" readonly>
                    </div>

                    <div class="single-input-item mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <div class="position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu mới" style="padding-right: 40px;">
                            <span class="toggle-password" toggle="#password" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; color: #999;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        @error('password')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="single-input-item mb-4">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu" style="padding-right: 40px;">
                            <span class="toggle-password" toggle="#password_confirmation" style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer; color: #999;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>


                    <div class="single-input-item text-center">
                        <button type="submit" class="btn btn-sqr w-100">Đặt lại mật khẩu</button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-primary" style="text-decoration: none;">
                        <i class="fa fa-arrow-left me-1"></i> Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
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
</script>
@endsection