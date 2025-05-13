@extends('admin.layouts.app')
@section('title', 'Danh Sách Vai Trò')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <h4 class="mb-0">Danh Sách Vai Trò</h4>
                    </div>
                    <a href="{{ route('admin.roleCreate') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Thêm Vai Trò
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle mb-0">
                            <thead class="table-light text-center">
                                <tr>
                                    <th width="50">STT</th>
                                    <th>Tên Vai Trò</th>
                                    <th>Mô Tả</th>
                                    <th width="180">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $index => $role)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.roleEdit', $role->id) }}"
                                                class="btn btn-sm btn-warning me-1">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <form action="{{ route('admin.destroyRole', $role->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Không có vai trò nào được tìm thấy.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination nếu có --}}
                    @if($roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $roles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection