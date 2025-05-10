@extends('admin.layouts.app')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Quản lý Tác Giả</h4>
                        </div>
                    </div>
                </div>

                {{-- Hiển thị thông báo thành công --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Hiển thị lỗi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0">Danh Sách Tác Giả</h5>
                                <a href="{{ route('authors.create') }}" class="btn btn-primary">Thêm Tác Giả</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th>Tiểu Sử</th>
                                            <th>Ngày Sinh</th>
                                            <th>Ngày Tạo</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($authors as $author)
                                            <tr>
                                                <td>{{ $author->id }}</td>
                                                <td>{{ $author->name }}</td>
                                                <td>{{ Str::limit($author->bio, 50) }}</td>
                                                <td>{{ $author->birthdate ?? 'N/A' }}</td>
                                                <td>{{ optional($author->created_at)->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Phân trang -->
                                <div class="d-flex justify-content-center mt-4">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-rounded">
                                            {{-- Previous Page Link --}}
                                            @if ($authors->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link" aria-label="Previous">
                                                        <i class="fa fa-chevron-left"></i> Trước
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $authors->previousPageUrl() }}" aria-label="Previous">
                                                        <i class="fa fa-chevron-left"></i> Trước
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($authors->getUrlRange(1, $authors->lastPage()) as $page => $url)
                                                <li class="page-item {{ $authors->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($authors->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $authors->nextPageUrl() }}" aria-label="Next">
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
        </div>
    </div>
@endsection
