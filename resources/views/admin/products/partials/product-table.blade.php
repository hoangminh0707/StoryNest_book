<table class="table table-bordered align-middle mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Biến thể</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
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
                <td>
                    @foreach ($product->categories as $category)
                        <span class="badge bg-primary">{{ $category->name }}</span>
                    @endforeach
                </td>
                <td>
                    @if($product->product_type === 'variable' && $product->variants->count())
                        <ul class="list-unstyled mb-0">
                            @foreach($product->variants as $variant)
                                <li>
                                    @if($variant->attributeValues->count())
                                        <ul class="text-muted small">
                                            @foreach($variant->attributeValues as $attrValue)
                                                <li>{{ $attrValue->value }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Không có</span>
                    @endif
                </td>
                <td>
                    @if($product->product_type === 'variable' && $product->variants->count())
                        <ul class="list-unstyled mb-0">
                            @foreach($product->variants as $variant)
                                <li>
                                    <span class="text-muted">Giá:</span> {{ number_format($variant->variant_price, 0, ',', '.') }} đ
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span>{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    @endif
                </td>
                <td>
                    @if($product->product_type === 'variable' && $product->variants->count())
                        <ul class="list-unstyled mb-0">
                            @foreach($product->variants as $variant)
                                <li>
                                    <span class="text-muted">Số lượng:</span> {{ $variant->stock_quantity }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span>Số lượng: {{ $product->quantity }}</span>
                    @endif
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                <td data-column-id="action" class="gridjs-td text-center">
                    <div class="dropdown">
                        <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            ...
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.products.show', $product->id) }}">
                                    <i class="ri-eye-fill align-bottom me-2 text-muted"></i> Xem
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">
                                    <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Sửa
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown-item text-primary" data-bs-toggle="modal"
                                    data-bs-target="#bulkStatusModal"
                                    onclick="setSelectedProductId({{ $product->id }}, '{{ $product->status }}')">
                                    <i class="ri-loop-left-line align-bottom me-2 text-muted"></i> Cập nhật trạng thái
                                </a>

                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">Không có sản phẩm nào</td>
            </tr>
        @endforelse
    </tbody>
</table>



@if ($products->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endif