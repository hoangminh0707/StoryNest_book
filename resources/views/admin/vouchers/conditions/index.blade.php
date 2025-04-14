{{-- DANH SÁCH ĐIỀU KIỆN ÁP DỤNG --}}
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Điều Kiện Áp Dụng: <span class="text-primary">{{ $voucher->code }}</span></h5>
        <a href="{{ route('admin.voucher-conditions.create', $voucher->id) }}" class="btn btn-success btn-sm">
            <i class="mdi mdi-plus"></i> Thêm Điều Kiện
        </a>
    </div>
    <div class="card-body table-responsive">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conditions as $index => $condition)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($condition->condition_type) }}</span>
                        </td>
                        <td>
                            @if($condition->condition_type === 'product')
                                {{ $condition->product?->name ?? 'Sản phẩm đã xoá' }}
                            @elseif($condition->condition_type === 'category')
                                {{ $condition->category?->name ?? 'Danh mục đã xoá' }}
                            @else
                                <em>Không xác định</em>
                            @endif
                        </td>
                        <td>{{ $condition->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.voucher-conditions.edit', [$voucher->id, $condition->id]) }}" class="btn btn-warning btn-sm">
                                <i class="mdi mdi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.voucher-conditions.destroy', [$voucher->id, $condition->id]) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xoá điều kiện này không?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted text-center">Chưa có điều kiện nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
