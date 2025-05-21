<table class="table table-bordered align-middle mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Đánh giá</th>
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
             
                <td class="text-center">
                    @if($product->product_type === 'variable' && $product->variants->count())
                        @php
                            $prices = $product->variants->pluck('variant_price');
                            $minPrice = $prices->min();
                            $maxPrice = $prices->max();
                        @endphp
                        <span>
                            {{ number_format($minPrice, 0, ',', '.') }} đ
                            @if($minPrice != $maxPrice)
                                - {{ number_format($maxPrice, 0, ',', '.') }} đ
                            @endif
                        </span>
                    @else
                        <span>{{ number_format($product->price, 0, ',', '.') }} đ</span>
                    @endif
                </td>

                <td class="text-center">
                    @if($product->product_type === 'variable' && $product->variants->count())
                        @php
                            $totalQuantity = $product->variants->sum('stock_quantity');
                        @endphp
                        <span >{{ $totalQuantity }}</span>
                    @else
                        <span>{{ $product->quantity }}</span>
                    @endif
                </td>
                <td class="text-center">
                    @php
                        $avgRating = round($product->reviews->avg('rating'), 1); // Trung bình điểm
                        $totalReviews = $product->reviews->count(); // Số lượt đánh giá
                    @endphp

                    @if($totalReviews > 0)
                        <span>
                            {{-- Hiển thị icon sao --}}
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($avgRating))
                                <i class="text-warning mdi mdi-star"></i> 
                                @elseif ($i - $avgRating < 1)
                                <i class="text-warning mdi mdi-star"></i> 
                                @else
                                <i class="text-muted mdi mdi-star-outline"></i>
                                @endif
                            @endfor
                            <br>
                            <small>{{ $avgRating }}/5 ({{ $totalReviews }} đánh giá)</small>
                        </span>
                    @else
                        <span>Chưa có đánh giá</span>
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