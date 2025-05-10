@extends('client.layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm rounded-3 p-4 text-center">
                    <h3 class="mb-3">📩 Xác minh địa chỉ email của bạn</h3>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success">
                            ✅ Liên kết xác minh mới đã được gửi tới email của bạn.
                        </div>
                    @endif

                    <p class="text-muted mb-2">
                        Trước khi tiếp tục, vui lòng kiểm tra email và nhấn vào liên kết xác minh mà chúng tôi đã gửi cho
                        bạn.
                    </p>
                    <p class="text-muted">
                        Nếu bạn không nhận được email, bạn có thể yêu cầu gửi lại liên kết mới.
                    </p>

                    <form method="POST" action="{{ route('verification.resend') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-sqr">
                            🔁 Gửi lại email xác minh
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection