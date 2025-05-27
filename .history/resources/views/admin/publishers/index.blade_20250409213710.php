@extends('admin.layouts.app')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Quản lý Nhà Xuất Bản</h4>
                        </div>
                    </div>
                </div>

                {{-- Hiển thị thông báo thành công --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5 class="card-title mb-0">Danh Sách Nhà Xuất Bản</h5>
                                <a href="{{ route('publishers.create') }}" class="btn btn-primary">Thêm Nhà Xuất Bản</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th>Quốc Gia</th>
                                            <th>Địa Chỉ</th>
                                            <th>Ngày Tạo</th>
                                            <th>Hành Động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($publishers as $publisher)
                                            <tr>
                                                <td>{{ $publisher->id }}</td>
                                                <td>{{ $publisher->name }}</td>
                                                <td>{{ $publisher->nationality }}</td>
                                                <td>{{ $publisher->address }}</td>
                                                <td>{{ optional($publisher->created_at)->format('d-m-Y') }}</td>
                                                <td>
                                                    <a href="{{ route('publishers.edit', $publisher->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                                    <form action="{{ route('publishers.destroy', $publisher->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Phân trang --}}
                                <div class="d-flex justify-content-center mt-4">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination pagination-rounded">
                                            {{-- Previous Page Link --}}
                                            @if ($publishers->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link" aria-label="Previous">
                                                        <i class="fa fa-chevron-left"></i> Trước
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $publishers->previousPageUrl() }}" aria-label="Previous">
                                                        <i class="fa fa-chevron-left"></i> Trước
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($publishers->getUrlRange(1, $publishers->lastPage()) as $page => $url)
                                                <li class="page-item {{ ($publishers->currentPage() == $page) ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($publishers->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $publishers->nextPageUrl() }}" aria-label="Next">
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
                </div>

            </div>
        </div>
    </div>
@endsection
