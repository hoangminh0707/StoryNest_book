 
  @extends('client.layouts.app')

  @section('content')

  <div class="container py-5">
    <h2 class="mb-4">Xác minh địa chỉ email của bạn</h2>

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success">
            Liên kết xác minh mới đã được gửi tới email của bạn.
        </div>
    @endif

    <p>Trước khi tiếp tục, vui lòng xác minh email của bạn bằng cách nhấn vào liên kết chúng tôi đã gửi tới email.</p>
    <p>Nếu bạn không nhận được email, bạn có thể yêu cầu một email khác.</p>

    <form method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-primary mt-3">Gửi lại email xác minh</button>
    </form>
</div>

@endsection
