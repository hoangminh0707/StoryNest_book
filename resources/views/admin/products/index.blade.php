@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            {{-- Header: Thêm và Tìm kiếm --}}
            <div class="card-header border-0">
                <div class="row g-4">
                    <div class="col-sm-auto">
                        <a href="{{ route('products.create') }}" class="btn btn-success" id="addproduct-btn">
                            <i class="ri-add-line align-bottom me-1"></i> Thêm sản phẩm
                        </a>
                    </div>
                    <div class="col-sm">
                        <form method="GET" action="{{ route('products.index') }}" class="d-flex justify-content-sm-end">
                            <div class="search-box ms-2">
                                <input type="text" name="keyword" class="form-control" value="{{ request('keyword') }}" placeholder="Tìm sản phẩm...">
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
                                    href="{{ route('products.index') }}">
                                    Tất cả <span class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['all'] ?? 0 }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'published' ? 'active fw-semibold' : '' }}"
                                    href="{{ route('products.index', ['status' => 'published']) }}">
                                    Đã đăng <span class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['published'] ?? 0 }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request('status') == 'draft' ? 'active fw-semibold' : '' }}"
                                    href="{{ route('products.index', ['status' => 'draft']) }}">
                                    Nháp <span class="badge bg-danger-subtle text-danger align-middle rounded-pill ms-1">{{ $counts['draft'] ?? 0 }}</span>
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
                    <div class="tab-pane {{ request('status') == null || request('status') == 'all' ? 'active' : '' }}" id="productnav-all" role="tabpanel">
                        <div id="table-product-list-all" class="table-card gridjs-border-none">
                            @include('admin.products.partials.product-table', ['products' => $products])
                        </div>
                    </div>

                    {{-- Đã đăng --}}
                    <div class="tab-pane {{ request('status') == 'published' ? 'active' : '' }}" id="productnav-published" role="tabpanel">
                        <div id="table-product-list-published" class="table-card gridjs-border-none">
                            @include('admin.products.partials.product-table', ['products' => $products])
                        </div>
                    </div>

                    {{-- Nháp --}}
                    <div class="tab-pane {{ request('status') == 'draft' ? 'active' : '' }}" id="productnav-draft" role="tabpanel">
                        @if($products->count())
                        <div id="table-product-list-draft" class="table-card gridjs-border-none">
                            @include('admin.products.partials.product-table', ['products' => $products])
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

@endsection

@section('scripts')
<script>
    // Xử lý khi chọn/deselect tất cả
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.product-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Xử lý khi chọn một checkbox cụ thể
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            let selectAllCheckbox = document.getElementById('select-all');
            let totalCheckboxes = document.querySelectorAll('.product-checkbox').length;
            let checkedCheckboxes = document.querySelectorAll('.product-checkbox:checked').length;

            // Nếu tất cả checkbox được chọn, chọn checkbox "chọn tất cả"
            if (totalCheckboxes === checkedCheckboxes) {
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.checked = false;
            }
        });
    });
</script>

@endsection