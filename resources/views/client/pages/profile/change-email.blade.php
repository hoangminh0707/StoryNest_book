@extends('client.layouts.app')

@section('content')
<div class="container py-4">
    <h4>Đổi địa chỉ Email</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="alert alert-danger" role="alert">
        Lưu ý mỗi tài khoản chỉ được đổi mail 1 lần nên bạn hãy cẩn trọng khi đổi email nhé!
      </div>

    <form action="{{ route('user.email.change') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email mới</label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật email</button>
    </form>
</div>
@endsection
