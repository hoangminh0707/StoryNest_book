@extends('admin.layouts.app')
@section('title', 'Lịch sử cập nhật')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 fw-bold">Lịch sử cập nhật tồn kho: <span class="text-primary">{{ $product->name }}</span></h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th scope="col">STT</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên SP</th>
                                <th scope="col">Biến thể</th>
                                <th scope="col">Người cập nhật</th>
                                <th scope="col">SL trước</th>
                                <th scope="col">SL thay đổi</th>
                                <th scope="col">SL sau</th>
                                <th scope="col">Ghi chú</th>
                                <th scope="col">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stockLogs as $key => $log)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        <img src="{{ Storage::url($log->product->thumbnail->image_path) }}" alt="" width="60px"
                                            height="60px">
                                    </td>
                                    <td class="text-center">{{ $log->product->name }}</td>

                                    <td>
                                        @if ($log->variant && $log->variant->attributeValues->count())
                                            @foreach ($log->variant->attributeValues as $attr)
                                                <span class="badge bg-secondary me-1">
                                                    {{ $attr->attribute->name }}: {{ $attr->value }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sản phẩm đơn</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $log->admin?->name ?? 'Khách hàng' }}</td>
                                    <td class="text-center">{{ $log->stock_before }}</td>
                                    <td
                                        class="text-center fw-bold {{ $log->change_quantity < 0 ? 'text-danger' : 'text-success' }}">
                                        {{ $log->change_quantity > 0 ? '+' : '' }}{{ $log->change_quantity }}
                                    </td>
                                    <td class="text-center">{{ $log->stock_after }}</td>
                                    <td>{{ $log->note ?? '—' }}</td>
                                    <td class="text-center">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Không có dữ liệu lịch sử tồn kho.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $stockLogs->links() }}
                </div>

                <!-- Back -->
                <div class="mt-4">
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection