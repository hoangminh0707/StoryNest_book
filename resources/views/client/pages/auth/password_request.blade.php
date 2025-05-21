@extends('client.layouts.app')

@section('content')
<section class="auth-section container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="login-reg-form-wrap p-4 shadow rounded bg-white">
                <h4 class="text-center mb-4">Quên mật khẩu</h4>
                {{-- Hiển thị thông báo thành công --}}
                @if (session('status'))
                    <div class="alert alert-success text-center">
                        {{ session('status') }}
                    </div>
                @endif
                {{-- Form gửi email --}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="single-input-item mb-3">
                        <label for="email" class="form-label">Email của bạn</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email..." value="{{ old('email') }}">
                        @error('email')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="single-input-item mt-4 text-center">
                        <button type="submit" class="btn btn-sqr w-100">Gửi liên kết đặt lại mật khẩu</button>
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
@endsection
