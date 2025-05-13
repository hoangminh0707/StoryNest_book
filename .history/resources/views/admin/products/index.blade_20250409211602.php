@extends('admin.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4>Quản lý Sản Phẩm</h4>
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i> Thêm Sản Phẩm
                </a>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i> {{ session('success') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình Ảnh</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Mô Tả</th>
                                <th>Giá</th>
                                <th>Danh Mục</th>
                                <th>Tác Giả</th>
                                <th>Nhà Xuất Bản</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->images->count() > 0)
                                    <img src="{{ asset('storage/' . optional($product->images->where('is_thumbnail', true)->first())->image_path ?? ($product->images->first()->image_path ?? '')) }}" width="50" height="50" alt="Product Image">
                                    @else
                                    <span class="badge badge-warning">Không có ảnh</span>
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ Str::limit($product->description, 50) }}</td>
                                <td>{{ number_format($product->price) }} VND</td>
                                <td>{{ $product->category->name ?? 'Không có' }}</td>
                                <td>{{ $product->author->name ?? 'Không có' }}</td>
                                <td>{{ $product->publisher->name ?? 'Không có' }}</td>
                                <td>{{ $product->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Sửa
                                    </a>

                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Phân trang nếu có -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-rounded">
                                {{-- Previous Page Link --}}
                                @if ($products->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Previous">
                                        <i class="fa fa-chevron-left"></i> Trước
                                    </span>
                                </li>
                                @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                        <i class="fa fa-chevron-left"></i> Trước
                                    </a>
                                </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <li class="page-item {{ ($products->currentPage() == $page) ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($products->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                        <i class="fa fa-chevron-right"></i> Sau
                                    </a>
                                </li>
                                @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Next">
                                        <i class="fa fa-chevron-right"></i> Sau
                                    </span>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection