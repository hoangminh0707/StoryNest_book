@extends('admin.layouts.app')
@section('title', 'Flash Deals')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary fw-bold">Danh Sách Flash Deals</h5>
                <a href="{{ route('admin.flash_deals.create') }}" class="btn btn-success">
                    <i class="fa fa-plus me-1"></i> Tạo Flash Deal Mới
                </a>
            </div>

            <div class="card-body">

                {{-- Form tìm kiếm & lọc --}}
                <form action="{{ route('admin.flash_deals.index') }}" method="GET" class="row g-3 mb-4 align-items-end">

                <div class="col-md-4">
                    <label for="search_title" class="form-label">Tiêu đề</label>
                    <input type="text" name="search_title" id="search_title" class="form-control"
                        value="{{ request('search_title') }}" placeholder="Tìm theo tiêu đề...">
                </div>

               

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-search me-1"></i> Tìm kiếm
                    </button>
                </div>

                </form>


                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>STT</th>
                                <th>Tiêu Đề</th>
                                <th>Thời Gian Bắt Đầu</th>
                                <th>Thời Gian Kết Thúc</th>
                               
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($flashDeals as $index => $deal)
                            <tr>
                                <td>{{ $flashDeals->firstItem() + $index }}</td>
                                <td class="text-start fw-bold">{{ $deal->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($deal->start_time)->format('d-m-Y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($deal->end_time)->format('d-m-Y H:i') }}</td>
                                <td>{{ $deal->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.flash_deals.edit', $deal->id) }}" class="btn btn-sm btn-warning me-1" title="Sửa">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.flash_deals.destroy', $deal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa flash deal này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-muted">Chưa có flash deal nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $flashDeals->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
