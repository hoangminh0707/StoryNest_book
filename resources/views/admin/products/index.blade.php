@extends('admin.layouts.app')
@section('title', 'Sản phẩm')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold">Danh Sách Sản Phẩm</h5>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Thêm Sản Phẩm
                </a>
            </div>

            <div class="card-body">

                {{-- Thông báo --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fa fa-exclamation-circle me-1"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th class="text-start">Mô Tả</th>
                                <th>Giá</th>
                                <th>Danh Mục</th>
                                <th>Tác Giả</th>
                                <th>NXB</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $index }}</td>
                                    <td>
                                        @if($product->images->count())
                                            <img src="{{ asset('storage/' . ($product->images->where('is_thumbnail', true)->first()->image_path ?? $product->images->first()->image_path)) }}"
                                                 class="rounded shadow-sm" width="50" height="50" alt="Ảnh sản phẩm">
                                        @else
                                            <span class="badge bg-warning text-dark">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td class="text-start">{{ $product->name }}</td>
                                    <td class="text-start">
                                        {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                                    </td>                                    
                                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->author->name ?? '-' }}</td>
                                    <td>{{ $product->publisher->name ?? '-' }}</td>
                                    <td>{{ $product->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
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

                {{-- Phân trang --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
