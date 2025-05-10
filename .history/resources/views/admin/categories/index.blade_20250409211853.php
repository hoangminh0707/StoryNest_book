@extends('admin.layouts.app')
@section('content')
    
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Quản lý Danh Mục</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="#">Danh Mục</a></li>
                                    <li class="breadcrumb-item active">Danh Sách</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0">Danh Sách Danh Mục</h5>
                                <a href="{{ route('categories.create') }}" class="btn btn-primary">Thêm Danh Mục</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên Danh Mục</th>
                                            <th>Mô Tả</th>
                                            <th>Danh Mục Cha</th>
                                            <th>Ngày Tạo</th>
                                            <th>Ngày Cập Nhật</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>{{ $category->parent ? $category->parent->name : 'N/A' }}</td>
                                                <td>{{ $category->created_at }}</td>
                                                <td>{{ $category->updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Phân trang --}}
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-rounded">
                        {{-- Previous Page Link --}}
                        @if ($categories->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-label="Previous">
                                    <i class="fa fa-chevron-left"></i> Trước
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->previousPageUrl() }}" aria-label="Previous">
                                    <i class="fa fa-chevron-left"></i> Trước
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            <li class="page-item {{ ($categories->currentPage() == $page) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($categories->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->nextPageUrl() }}" aria-label="Next">
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
            {{-- End Phân trang --}}
            </div>
        </div>
    </div>
@endsection