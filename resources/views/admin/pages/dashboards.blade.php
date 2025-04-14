@extends('admin.layouts.app')
@section('title', 'Bảng điều khiển')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h2 class="mb-3">Chào mừng đến với Bảng điều khiển</h2>
                    <p class="mb-2">Bạn đã đăng nhập thành công.</p>
                    <p><strong>Người dùng:</strong> {{ $user->name }}</p>

                    <form action="{{ route('admin.logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt me-1"></i> Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
