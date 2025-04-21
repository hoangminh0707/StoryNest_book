@extends('admin.layouts.app')
@section('title', 'Quản lý người dùng')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Danh sách người dùng</h4>
                <a href="{{ route('admin.userCreate') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Thêm người dùng
                </a>
            </div>
            <div class="card-body">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.userIndex') }}" class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tên hoặc email..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </form>

                <!-- Users Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>Avatar</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Vai trò</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>

                                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://i.ibb.co/R4Hqy0Lm/download.jpg' }}"
                                            width="40" height="40" class="rounded-circle">

                                    </td>
                                    <td>{{ ucfirst($user->gender) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->birthdate)->format('d/m/Y') }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>{{ $user->address ?? '-' }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge bg-secondary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.userEdit', $user->id) }}" class="btn btn-sm btn-success me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.userDelete', $user->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-muted">Không có người dùng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection