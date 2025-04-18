@extends('admin.layouts.app')
@section('title', 'Danh sách Biến Thể Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Danh sách Biến Thể Sản Phẩm</h4>
                <a href="{{ route('admin.product-variants.create') }}" class="btn btn-primary">
                    <i class="mdi mdi-plus"></i> Thêm Biến Thể
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Thuộc Tính</th>
                                <th>Giá Bán</th>
                                <th>Tồn Kho</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($variants as $index => $variant)
                                <tr>
                                    <td>{{ ($variants->currentPage() - 1) * $variants->perPage() + $index + 1 }}</td>
                                    <td>{{ $variant->product->name ?? 'Không rõ' }}</td>
                                    <td class="text-start">
                                        @foreach($variant->attributeValues as $value)
                                            <span class="badge bg-info me-1">
                                                {{ $value->attribute->name }}: {{ $value->value }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format($variant->variant_price) }} đ</td>
                                    <td>{{ $variant->stock_quantity }}</td>
                                    <td>
                                        <a href="{{ route('admin.product-variants.edit', $variant->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.product-variants.destroy', $variant->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Bạn có chắc muốn xóa không?')"
                                                class="btn btn-sm btn-danger">
                                                <i class="mdi mdi-delete"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Không có biến thể nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($variants->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $variants->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection