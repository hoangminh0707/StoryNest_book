@extends('admin.layouts.app')
@section('title', 'Sản phẩm')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold">Danh Sách Sản Phẩm</h5>
                <a href="{{ route('products.create') }}" class="btn btn-primary mt-2 mt-sm-0">
                    <i class="fa fa-plus me-1"></i> Thêm Sản Phẩm
                </a>
            </div>

            {{-- Bộ lọc --}}
            <div class="card-body border-bottom pb-0">
                <form action="{{ route('products.index') }}" method="GET" class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Tên sản phẩm</label>
                        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Danh mục</label>
                        <select name="category_id" class="form-select">
                            <option value="">Tất cả</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tác giả</label>
                        <select name="author_id" class="form-select">
                            <option value="">Tất cả</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-secondary w-100" type="submit"><i class="fa fa-filter me-1"></i>Lọc</button>
                    </div>
                </form>
            </div>

            <div class="card-body pt-3">
                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.bulkDelete') }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>
                                        <input type="checkbox" id="checkAll">
                                    </th>
                                    <th>Ảnh</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Giá</th>
                                    <th>Danh Mục</th>
                                    <th>Tác Giả</th>
                                    <th>NXB</th>
                                    <th>Ngày Tạo</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" value="{{ $product->id }}"></td>
                                        <td>
                                            @if($product->images->count())
                                                <img src="{{ asset('storage/' . ($product->images->where('is_thumbnail', true)->first()->image_path ?? $product->images->first()->image_path)) }}"
                                                    class="rounded shadow-sm" alt="Ảnh" width="50" height="50">
                                            @else
                                                <span class="badge bg-warning text-dark">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td class="text-start">{{ $product->name }}</td>
                                        <td>{{ number_format($product->price) }} VND</td>
                                        <td>{{ $product->category->name ?? '-' }}</td>
                                        <td>{{ $product->author->name ?? '-' }}</td>
                                        <td>{{ $product->publisher->name ?? '-' }}</td>
                                        <td>{{ $product->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                  class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-muted">Không có sản phẩm nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Nút xóa hàng loạt --}}
                    <div class="mt-2">
                        <button class="btn btn-danger" type="submit">
                            <i class="fa fa-trash me-1"></i> Xóa Đã Chọn
                        </button>
                    </div>
                </form>

                {{-- Pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript chọn tất cả --}}
@push('scripts')
<script>
    document.getElementById('checkAll').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endpush
@endsection
