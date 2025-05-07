<!-- resources/views/user/profile.blade.php -->
@extends('client.layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Sidebar user info and navigation -->
            <div class="col-md-3">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <!-- User avatar, default to placeholder if not set -->
                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://i.ibb.co/WpKLtySw/Logo-Story-Nest-Book.jpg' }}"
                            alt="Avatar" class="rounded-circle mb-3" width="100" height="100">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <!-- Display member since month/year -->
                        <p class="text-muted">Thành viên từ {{ $user->created_at->format('m/Y') }}</p>
                    </div>
                </div>
                <!-- Navigation links -->
                <ul class="list-group">
                    <li class="list-group-item title">Thông tin tài khoản</li>
                    <li class="list-group-item"><a href="{{ route('profile.password.form') }}">Đổi mật khẩu</a>
                    </li>
                    <li class="list-group-item"><a href="{{ route('orders.index') }}">Đơn hàng của tôi</a></li>
                    <li class="list-group-item"><a href="{{ route('addresses.index') }}">Địa chỉ đã lưu</a></li>
                    @if (is_null($user->email_verified_at) && $user->can_change_email)
                        <li class="list-group-item">
                            <a href="{{ route('profile.email.change.form') }}">Đổi Email</a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Main profile form content -->
            <div class="col-md-9">

                <!-- Thống kê tổng quát -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Tổng chi tiêu</h6>
                                <h4 class="text-success">{{ number_format($totalSpent, 0, ',', '.') }}₫</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Tổng sản phẩm đã mua</h6>
                                <h4 class="text-primary">{{ $totalProducts }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <h6 class="text-muted">Đơn hàng hoàn tất</h6>
                                <h4 class="text-info">{{ $completedOrders }}</h4>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <!-- Card header -->
                    <div class="card-header text-dark">Cập nhật thông tin cá nhân</div>
                    <div class="card-body">
                        <!-- Form to update user profile -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Name input -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}">
                            </div>

                            <!-- Email input (read-only) -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                            </div>

                            @if (is_null($user->email_verified_at))
                                <div class="text-danger mt-1">
                                    <i class="bi bi-exclamation-circle-fill"></i> Vui lòng xác minh email để sử dụng đầy đủ chức
                                    năng.
                                    <strong><a href="{{ route('verification.notice') }}">Tại Đây</a></strong>
                                </div>
                            @endif

                            <!-- Phone input -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}">
                            </div>

                            <!-- Birthdate input -->
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate"
                                    value="{{ old('birthdate', $user->birthdate) }}">
                            </div>

                            <!-- Gender radio buttons -->
                            <div class="mb-3">
                                <label class="form-label">Giới tính</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="male">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="female">Nữ</label>
                                </div>
                            </div>


                            <!-- Avatar file upload -->
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Ảnh đại diện</label>
                                <input type="file" class="form-control" id="avatar" name="avatar">
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-sqr">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection