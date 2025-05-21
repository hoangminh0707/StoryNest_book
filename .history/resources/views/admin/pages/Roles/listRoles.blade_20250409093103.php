@extends('admin.layouts.app')
@section('title', 'Danh Sách Vai Trò')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh Sách Vai Trò</h5>
                <a href="{{ route('admin.roleCreate') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Thêm Vai Trò
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">ID</th>
                                <th>Tên Vai Trò</th>
                                <th>Mô Tả</th>
                                <th width="160" class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.roleEdit', $role->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.destroyRole', $role->id) }}" method="POST" class="d-inline">
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
                                    <td colspan="4" class="text-center text-muted">Không có vai trò nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            
            </div>
        </div>
    </div>
</div>
@endsection
