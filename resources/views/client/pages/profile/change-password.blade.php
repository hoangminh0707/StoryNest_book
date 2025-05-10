@extends('client.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm rounded-3 p-4">
                    <h4 class="mb-4 text-center">🔒 Đổi mật khẩu</h4>

                    @if(session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" placeholder="Nhập mật khẩu cũ" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-sqr">✔ Xác nhận đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection