<table class="table table-bordered align-middle mb-0">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="select-all" class="form-check-input">
            </th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Loại</th>
            <th>Biến thể</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>
                    <input type="checkbox" class="product-checkbox form-check-input" data-product-id="{{ $product->id }}">
                </td>
                <td>
                    @php
                        $thumbnail = $product->images->firstWhere('is_thumbnail', true);
                    @endphp
                    @if($thumbnail)
                        <img src="{{ asset($thumbnail->image_path) }}" alt="Thumbnail" width="80">
                    @else
                        <span>Không có ảnh</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>
                    @if($product->product_type == 'variable')
                        <span class="badge bg-info">Có biến thể</span>
                    @else
                        <span class="badge bg-secondary">Đơn giản</span>
                    @endif
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

                                    <span class="text-muted">Giá:</span> {{ number_format($variant->stock_quantity , 0, ',', '.') }} đ
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <!-- Hiển thị giá của sản phẩm khi không có biến thể -->
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
                        <!-- Hiển thị giá của sản phẩm khi không có biến thể -->
                        <span>Số lượng: {{ $product->quantity }}</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $product->status == 'published' ? 'success' : 'secondary' }}">
                        {{ $product->status == 'published' ? 'Đã đăng' : 'Nháp' }}
                    </span>
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info"
                        title="Xem chi tiết">
                        <i class="ri-eye-line"></i>
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning"
                        title="Chỉnh sửa">
                        <i class="ri-edit-line"></i>
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá sản phẩm này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Xoá sản phẩm">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </form>
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