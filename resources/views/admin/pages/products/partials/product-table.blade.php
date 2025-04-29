<button id="delete-selected" class="btn btn-danger hidden">
    Xóa đã chọn
</button>

<table class="table table-bordered align-middle mb-0">
    <thead>
        <tr>
            <th>
                <input type="checkbox" id="select-all" class="form-check-input">
            </th>
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
            <td>
                <input type="checkbox" class="product-checkbox form-check-input" data-product-id="{{ $product->id }}">
            </td>
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
                    <button class="btn btn-soft-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" id="delete-form-{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <a href="#" class="dropdown-item text-danger" title="Xoá sản phẩm" onclick="confirmDelete({{ $product->id }})">
                                    <i class="ri-delete-bin-line align-bottom me-2 text-muted"></i> Xóa
                                </a>
                            </form>
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


<script>
    // Xử lý sự kiện click cho các hành động trong dropdown
    document.querySelectorAll('.remove-list').forEach(function(button) {
        button.addEventListener('click', function(event) {
            var itemId = event.target.getAttribute('data-id');
            // Tại đây bạn có thể xử lý logic xóa hoặc thực hiện hành động khác với itemId
            console.log('Đã chọn xóa mục với ID: ' + itemId); // In ra ID mục để kiểm tra
        });
    });

    function confirmDelete(productId) {
        if (confirm('Bạn có chắc chắn muốn xoá sản phẩm này?')) {
            document.getElementById('delete-form-' + productId).submit();
        }
    }
</script>


<script>
    // Cập nhật trạng thái của nút "Xóa đã chọn"
    const selectAllCheckbox = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const deleteSelectedBtn = document.getElementById('delete-selected');

    // Cập nhật nút Xóa khi có ít nhất một checkbox được chọn
    function updateDeleteButtonState() {
        const anyChecked = document.querySelectorAll('.product-checkbox:checked').length > 0;
        if (anyChecked) {
            deleteSelectedBtn.classList.remove('hidden'); // bỏ ẩn nút
            setTimeout(() => {
                deleteSelectedBtn.classList.add('active'); // thêm active để nút hiện ra mượt mà
            }, 10);
        } else {
            deleteSelectedBtn.classList.remove('active');
            setTimeout(() => {
                deleteSelectedBtn.classList.add('hidden'); // ẩn nút sau khi mờ dần
            }, 300); // delay đúng thời gian transition
        }
    }

    // Sự kiện chọn tất cả
    selectAllCheckbox.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButtonState();
    });

    // Sự kiện thay đổi trạng thái từng checkbox
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateDeleteButtonState();
        });
    });

    // Lần đầu load, nút Xóa sẽ bị ẩn
    deleteSelectedBtn.classList.add('hidden');
    deleteSelectedBtn.classList.remove('active');

    // Xử lý xóa sản phẩm đã chọn
    deleteSelectedBtn.addEventListener('click', function() {
        const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');

        if (selectedCheckboxes.length > 0 && confirm('Bạn có chắc chắn muốn xóa các sản phẩm đã chọn?')) {
            const productIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.dataset.productId);

            // Tạo form xóa sản phẩm cho từng ID
            productIds.forEach(productId => {
                const form = document.createElement('form');
                form.action = `/admin/products/${productId}`; // Đảm bảo URL này đúng
                form.method = 'POST';
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = '{{ csrf_token() }}'; // Thêm token CSRF
                form.appendChild(csrfField);
                document.body.appendChild(form);
                form.submit();
            });
        }
    });

    // Hàm xác nhận xóa sản phẩm đơn lẻ
    function confirmDelete(productId) {
        if (confirm('Bạn có chắc chắn muốn xoá sản phẩm này?')) {
            document.getElementById('delete-form-' + productId).submit();
        }
    }
</script>

<style>
    /* Khi ẩn hoàn toàn */
    .hidden {
        display: none;
    }

    /* Khi có nút, animation mờ dần */
    #delete-selected {
        opacity: 0;
        transition: opacity 0.3s ease;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 1000;
    }

    /* Khi active, opacity = 1 */
    #delete-selected.active {
        opacity: 1;
    }
</style>