@extends('admin.layouts.app')

@section('title', 'Sản phẩm')


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- Header: Thêm và Tìm kiếm --}}
                <div class="card-header border-0">
                    <div class="row g-4">
                        <div class="col-sm-auto">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success" id="addproduct-btn">
                                <i class="ri-add-line align-bottom me-1"></i> Thêm sản phẩm
                            </a>
                        </div>
                        <div class="col-sm">
                            <form method="GET" action="{{ route('admin.products.index') }}"
                                class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}"
                                        placeholder="Tìm sản phẩm...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <ul class="nav nav-tabs-custom card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ request('status') == null || request('status') == 'all' ? 'active fw-semibold' : '' }}"
                                        href="{{ route('admin.products.index') }}">
                                        Tất cả <span
                                            class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['all'] ?? 0 }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('status') == 'published' ? 'active fw-semibold' : '' }}"
                                        href="{{ route('admin.products.index', ['status' => 'published']) }}">
                                        Đã đăng <span
                                            class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['published'] ?? 0 }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('status') == 'discontinued' ? 'active fw-semibold' : '' }}"
                                        href="{{ route('admin.products.index', ['status' => 'discontinued']) }}">
                                        Ngưng kinh doanh <span
                                            class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['discontinued'] ?? 0 }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request('status') == 'draft' ? 'active fw-semibold' : '' }}"
                                        href="{{ route('admin.products.index', ['status' => 'draft']) }}">
                                        Nháp <span
                                            class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['draft'] ?? 0 }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body">
                    <div class="tab-content text-muted">
                        {{-- Tất cả --}}
                        <div class="tab-pane {{ request('status') == null || request('status') == 'all' ? 'active' : '' }}"
                            id="productnav-all" role="tabpanel">
                            <div id="table-product-list-all" class="table-card gridjs-border-none">
                                @include('admin.pages.products.partials.product-table', ['products' => $products])
                            </div>
                        </div>

                        {{-- Đã đăng --}}
                        <div class="tab-pane {{ request('status') == 'published' ? 'active' : '' }}"
                            id="productnav-published" role="tabpanel">
                            <div id="table-product-list-published" class="table-card gridjs-border-none">
                                @include('admin.pages.products.partials.product-table', ['products' => $products])
                            </div>
                        </div>

                        {{-- Đã đăng --}}
                        <div class="tab-pane {{ request('status') == 'discontinued' ? 'active' : '' }}"
                            id="productnav-discontinued" role="tabpanel">
                            <div id="table-product-list-discontinued" class="table-card gridjs-border-none">
                                @include('admin.pages.products.partials.product-table', ['products' => $products])
                            </div>
                        </div>

                        {{-- Nháp --}}
                        <div class="tab-pane {{ request('status') == 'draft' ? 'active' : '' }}" id="productnav-draft"
                            role="tabpanel">
                            @if($products->count())
                                <div id="table-product-list-draft" class="table-card gridjs-border-none">
                                    @include('admin.pages.products.partials.product-table', ['products' => $products])
                                </div>
                            @else
                                <div class="py-4 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#405189,secondary:#0ab39c" style="width:72px;height:72px">
                                    </lord-icon>
                                    <h5 class="mt-4">Không tìm thấy sản phẩm</h5>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal cập nhật trạng thái sản phẩm -->
    <div class="modal fade" id="bulkStatusModal" tabindex="-1" aria-labelledby="bulkStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="bulk-status-form" method="POST" action="{{ route('admin.products.bulkUpdateStatus') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bulkStatusModalLabel">Cập nhật trạng thái sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="product_ids" id="selected-product-ids">
                        <div class="mb-3">
                            <label for="status" class="form-label">Chọn trạng thái</label>
                            <select class="form-select" name="status" required>
                                <option value="">-- Chọn trạng thái --</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Đã đăng
                                </option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                                <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Ngừng
                                    kinh doanh</option>
                            </select>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function setSelectedProductId(id, currentStatus = '') {
            const input = document.getElementById('selected-product-ids');
            const select = document.getElementById('status');
            if (input) input.value = id;
            if (select && currentStatus) select.value = currentStatus;
        }

    </script>

@endsection