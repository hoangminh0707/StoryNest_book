@extends('admin.layouts.app')
@section('title', 'Nhà Xuất Bản')

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

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card danh sách --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Danh Sách Nhà Xuất Bản</h5>
                    <a href="{{ route('admin.publishers.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> Thêm Nhà Xuất Bản
                    </a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Quốc Gia</th>
                                <th>Địa Chỉ</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($publishers as $index => $publisher)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $publisher->name }}</td>
                                    <td>{{ $publisher->nationality }}</td>
                                    <td>{{ $publisher->address }}</td>
                                    <td>{{ $publisher->created_at?->format('d-m-Y') ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.publishers.edit', $publisher->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="mdi mdi-pencil"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.publishers.destroy', $publisher->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                <i class="mdi mdi-delete"></i> Xóa
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-muted text-center">Không có nhà xuất bản nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($publishers->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $publishers->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection