@extends('client.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4">
                    <h4 class="mb-3 text-center">📧 Đổi địa chỉ Email</h4>

                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    <div class="alert alert-warning small text-center">
                        ⚠️ <strong>Lưu ý:</strong> Mỗi tài khoản chỉ được đổi email <u>một lần</u>, hãy chắc chắn với địa
                        chỉ bạn cung cấp.
                    </div>

                    <form action="{{ route('profile.email.change') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email mới</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Nhập địa chỉ email mới" required value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-sqr">✔ Cập nhật email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection