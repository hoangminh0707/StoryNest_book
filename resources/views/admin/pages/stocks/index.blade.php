@extends('admin.layouts.app')
@section('title', 'Kho hàng')
@section('content')
<div class="row">
    <div class="card">
        <!-- Form tìm kiếm sản phẩm -->
        <form method="GET" action="{{ route('admin.stocks.index') }}" class="mt-4 mb-4">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group shadow-sm">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="🔍 Tìm theo tên sản phẩm hoặc biến thể..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Form bộ lọc -->
        <form method="GET" class="mb-4">
            <div class="row mb-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', $startDate) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', $endDate) }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Lọc
                    </button>
                </div>
            </div>

            <!-- Tabs lọc trạng thái tồn kho -->
            <div class="row">
                <div class="col">
                    <ul class="nav nav-pills">
                        @php $status = request('stock_status'); @endphp

                        <li class="nav-item me-2">
                            <a class="nav-link {{ $status === null ? 'active' : '' }}"
                                href="{{ route('admin.stocks.index', array_merge(request()->except('page', 'stock_status'))) }}">
                                Tất cả
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $status === 'in_stock' ? 'active' : '' }}"
                                href="{{ route('admin.stocks.index', array_merge(request()->except('page'), ['stock_status' => 'in_stock'])) }}">
                                Còn nhiều
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $status === 'low_stock' ? 'active' : '' }}"
                                href="{{ route('admin.stocks.index', array_merge(request()->except('page'), ['stock_status' => 'low_stock'])) }}">
                                Sắp hết
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link {{ $status === 'out_of_stock' ? 'active' : '' }}"
                                href="{{ route('admin.stocks.index', array_merge(request()->except('page'), ['stock_status' => 'out_of_stock'])) }}">
                                Hết hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>

        <!-- Bảng quản lý tồn kho -->
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Tồn kho</th>
                    <th>Đã bán</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                @php
                $stock = $product->total_stock;
                $soldThisMonth = $product->sold_this_month;
                $status = $stock == 0 ? 'Hết hàng' : ($stock <= 10 ? 'Sắp hết' : 'Còn nhiều' );
                    $statusColor=$stock==0 ? 'danger' : ($stock <=10 ? 'warning' : 'success' );
                    @endphp

                    <tr>
                    <td>{{ $products->firstItem() + $index }}</td>
                    <td>
                        @php
                        $thumbnail = $product->images->firstWhere('is_thumbnail', true);
                        @endphp
                        @if($thumbnail)
                        <img src="{{ Storage::url($thumbnail->image_path) }}" alt="Thumbnail" width="50">
                        @else
                        <span>Không có ảnh</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->total_stock }}</td>
                    <td>{{ $product->sold_this_period }}</td>
                    <td><span class="badge bg-{{ $statusColor }}">{{ $status }}</span></td>
                    <td>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStockModal{{ $product->id }}">Cập nhật</button>
                        <a href="{{ route('admin.stocks.history', $product->id) }}" class="btn btn-info">
                            <i class=" bx bx-history"></i> lịch sử 
                        </a>



                    </td>
                    </tr>
                    <!-- cập nhật  -->
                    <div class="modal fade" id="updateStockModal{{ $product->id }}" tabindex="-1" aria-labelledby="updateStockModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cập nhật tồn kho: {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.stocks.update') }}">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        @if ($errors->any() && old('product_id') == $product->id)
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var modal = new bootstrap.Modal(document.getElementById('updateStockModal{{ $product->id }}'));
                                                modal.show();
                                            });
                                        </script>
                                        @endif

                                        @if ($product->product_type === 'simple')
                                        <div class="mb-3">
                                            <label class="form-label">Thêm vào tồn kho</label>
                                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                                            <small class="text-muted d-block mt-1">Hiện tại: {{ $product->getTotalStockAttribute() }} sản phẩm</small>
                                            @error('quantity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        @elseif ($product->product_type === 'variable')
                                        <div class="mb-3">
                                            <label class="form-label">Biến thể</label>
                                            <select class="form-select" name="variant_id" id="variantSelect{{ $product->id }}">
                                                @foreach ($product->variants as $variant)
                                                <option value="{{ $variant->id }}" data-stock="{{ $variant->stock_quantity }}">
                                                    @foreach ($variant->attributeValues as $attr)
                                                    {{ $attr->attribute->name }}: {{ $attr->value }}@if (!$loop->last), @endif
                                                    @endforeach
                                                    (Còn {{ $variant->stock_quantity }} sản phẩm)
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Thêm vào tồn kho</label>
                                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}">
                                            <small class="text-muted d-block mt-1">
                                                <span id="currentStockText{{ $product->id }}">Hiện tại: {{ $product->variants->first()?->stock_quantity ?? 0 }} sản phẩm</span>
                                            </small>
                                            @error('quantity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        @endif

                                        <!-- Ghi chú -->
                                        <div class="mb-3">
                                            <label class="form-label">Ghi chú</label>
                                            <input type="text" name="note" class="form-control @error('note') is-invalid @enderror" value="{{ old('note') }}" placeholder="Nhập ghi chú (nếu có)">
                                            @error('note')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach ($products as $product)
            @if ($product->product_type === 'variable')
                const variantSelect{{ $product->id }} = document.getElementById('variantSelect{{ $product->id }}');
                const currentStockText{{ $product->id }} = document.getElementById('currentStockText{{ $product->id }}');

                if (variantSelect{{ $product->id }} && currentStockText{{ $product->id }}) {
                    // Hiển thị tồn kho của biến thể đầu tiên khi trang tải
                    const firstOption = variantSelect{{ $product->id }}.options[0];
                    const initialStock = firstOption.getAttribute('data-stock');
                    currentStockText{{ $product->id }}.textContent = `Hiện tại: ${initialStock} sản phẩm`;

                    // Cập nhật tồn kho khi người dùng thay đổi biến thể
                    variantSelect{{ $product->id }}.addEventListener('change', function () {
                        const selectedOption = variantSelect{{ $product->id }}.selectedOptions[0];
                        const stock = selectedOption.getAttribute('data-stock');
                        currentStockText{{ $product->id }}.textContent = `Hiện tại: ${stock} sản phẩm`;
                    });
                }
            @elseif ($product->product_type === 'simple')
                const simpleStockText{{ $product->id }} = document.getElementById('currentStockText{{ $product->id }}');
                if (simpleStockText{{ $product->id }}) {
                    // Hiển thị tồn kho cho sản phẩm đơn
                    simpleStockText{{ $product->id }}.textContent = `Hiện tại: {{ $product->getTotalStockAttribute() }} sản phẩm`;
                }
            @endif
        @endforeach
    });
</script>
@endsection