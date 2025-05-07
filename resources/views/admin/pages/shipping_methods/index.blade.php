@extends('admin.layouts.app')
@section('title', 'Phương Thức Vận Chuyển')

@section('content')
<div class="row">
    <div class="col-lg-12">

        {{-- Thông báo --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Card danh sách --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh Sách Phương Thức Vận Chuyển</h5>
                <a href="{{ route('admin.shipping-methods.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus"></i> Thêm Mới
                </a>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Nhà Cung Cấp</th>
                            <th>Phí Mặc Định</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shippingMethods as $index => $method)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            {{-- Ảnh --}}
                            <td>
                                @if($method->image)
                                <img src="{{ asset('storage/' . $method->image) }}" alt="Image" width="50" height="50" class="rounded">
                                @else
                                <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>

                            <td>{{ $method->name }}</td>
                            <td>{{ $method->provider ?? 'N/A' }}</td>
                            <td>{{ number_format($method->default_fee, 0, ',', '.') }}₫</td>
                            <td class="text-center">
                                <form action="{{ route('admin.shipping-methods.toggle-status', $method->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <div class="form-check form-switch d-flex justify-content-center mb-0">
                                        <input class="form-check-input" type="checkbox" name="is_active"
                                            onchange="this.form.submit()" {{ $method->is_active ? 'checked' : '' }}>
                                    </div>
                                </form>
                            </td>
                            <td>{{ $method->created_at->format('d-m-Y') }}</td>
                            <td>
                                <div class="d-flex flex-wrap justify-content-center gap-1">
                                    {{-- Sửa --}}
                                    <a href="{{ route('admin.shipping-methods.edit', $method->id) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    {{-- Xóa --}}
                                    <form action="{{ route('admin.shipping-methods.destroy', $method->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-muted text-center">Chưa có phương thức vận chuyển nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Phân trang --}}
                @if ($shippingMethods->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $shippingMethods->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection