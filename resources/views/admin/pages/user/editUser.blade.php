@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa người dùng')

@section('content')
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Chỉnh sửa người dùng</h4>
            <a href="{{ route('admin.userIndex') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.userUpdate', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Họ tên -->
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới (bỏ qua nếu không đổi)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <!-- Ảnh đại diện -->
                <div class="mb-3">
                    <label class="form-label">Ảnh đại diện</label>
                    <input type="file" name="avatar" class="form-control">
                    @if ($user->avatar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" width="100" class="img-thumbnail">
                        </div>
                    @endif
                </div>

                <!-- Giới tính -->
                <div class="mb-3">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select" required>
                        <option value="">-- Chọn giới tính --</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>

                <!-- Ngày sinh -->
                <div class="mb-3">
                    <label class="form-label">Ngày sinh</label>
                    <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}" required>
                </div>

                <!-- SĐT -->
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <!-- Địa chỉ -->
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address) }}</textarea>
                </div>

                <!-- Vai trò -->
                <div class="mb-3">
                    <label class="form-label">Vai trò</label>
                    <div class="row">
                        @foreach ($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->id }}"
                                        class="form-check-input"
                                        id="role_{{ $role->id }}"
                                        {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Bạn có thể chọn nhiều vai trò.</small>
                </div>

                <!-- Nút cập nhật -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Cập nhật người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
