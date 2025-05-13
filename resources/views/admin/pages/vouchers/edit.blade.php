@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Đã có lỗi xảy ra:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="code">Mã Voucher</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $voucher->code) }}" required>
                @error('code')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name">Tên Voucher</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $voucher->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $voucher->description) }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Loại Voucher</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="fixed" {{ old('type', $voucher->type) === 'fixed' ? 'selected' : '' }}>Cố định</option>
                    <option value="percent" {{ old('type', $voucher->type) === 'percent' ? 'selected' : '' }}>Theo phần trăm</option>
                </select>
                @error('type')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="value">Giá trị Voucher</label>
                <input type="number" name="value" id="value" class="form-control" value="{{ old('value', $voucher->value) }}" required>
                @error('value')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="max_discount_amount">Giảm giá tối đa</label>
                <input type="number" name="max_discount_amount" id="max_discount_amount" class="form-control" value="{{ old('max_discount_amount', $voucher->max_discount_amount) }}">
                @error('max_discount_amount')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="min_order_value" id="min_order_value" class="form-control" value="{{ old('min_order_value', $voucher->min_order_value) }}">
                @error('min_order_value')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="expires_at">Ngày hết hạn</label>
                <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at', $voucher->expires_at ? $voucher->expires_at->toDateString() : '') }}">
                @error('expires_at')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="max_usage">Sử dụng tối đa</label>
                <input type="number" name="max_usage" id="max_usage" class="form-control" value="{{ old('max_usage', $voucher->max_usage) }}">
                @error('max_usage')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_active">Kích hoạt</label>
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $voucher->is_active ?? false) ? 'checked' : '' }}>
                @error('is_active')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">Điều kiện áp dụng</label>
                <div id="applied_conditions" class="d-flex flex-wrap">
                    <!-- Thẻ điều kiện được thêm động tại đây -->
                    @foreach($voucher->conditions as $condition)
                    <div class="applied-condition d-flex align-items-center badge bg-info text-white me-2 mb-2">
                        @if ($condition->condition_type == 'product')
                        <span class="me-2"><i class="bi bi-box"></i> Sản phẩm: {{ $condition->product->name }}</span>
                        @elseif ($condition->condition_type == 'category')
                        <span class="me-2"><i class="bi bi-folder"></i> Danh mục: {{ $condition->category->name }}</span>
                        @endif
                        <!-- Nút xóa (nếu cần) -->
                        <button type="button" class="btn-close btn-close-white ms-2" aria-label="Close"></button>
                    </div>
                    @endforeach
                </div>
            </div>


            <div class="mb-3">
                <label for="condition_type" class="form-label">Áp dụng cho</label>
                <select name="condition_type" id="condition_type" class="form-control">
                    <option value="">-- Tất cả sản phẩm --</option>
                    <option value="product" {{ old('condition_type', $voucher->condition_type) === 'product' ? 'selected' : '' }}>Sản phẩm</option>
                    <option value="category" {{ old('condition_type', $voucher->condition_type) === 'category' ? 'selected' : '' }}>Danh mục</option>
                </select>
            </div>

            <!-- Phần sản phẩm -->
            <div class="mb-3" id="product_section" style="{{ old('condition_type', $voucher->condition_type) === 'product' ? 'display:block;' : 'display:none;' }}">
                <label class="form-label">Chọn sản phẩm</label>
                <select id="product_select" name="product_ids[]" class="form-control" multiple>
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}"
                        {{ in_array($product->id, old('product_ids', $voucher->conditions->where('condition_type', 'product')->pluck('product_id')->toArray())) ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Phần danh mục -->
            <div class="mb-3" id="category_section" style="{{ old('condition_type', $voucher->condition_type) === 'category' ? 'display:block;' : 'display:none;' }}">
                <label class="form-label">Chọn danh mục</label>
                <select id="category_select" name="category_ids[]" class="form-control" multiple>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('category_ids', $voucher->conditions->where('condition_type', 'category')->pluck('category_id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Hidden inputs để lưu điều kiện đã chọn -->
            <div id="hidden_inputs"></div>

            <button type="submit" class="btn btn-primary">Cập nhật Voucher</button>
        </form>
    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conditionType = document.getElementById('condition_type');
        const productSection = document.getElementById('product_section');
        const categorySection = document.getElementById('category_section');
        const removeButtons = document.querySelectorAll('.btn-close');

        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tagElement = this.closest('.applied-condition'); // Thẻ chứa điều kiện
                const type = tagElement.getAttribute('data-condition-type'); // Lấy loại điều kiện (product hoặc category)
                const id = this.getAttribute('data-id'); // Lấy ID của điều kiện
                removeCondition(type, id, tagElement); // Gọi hàm xóa điều kiện
            });
        });

        function toggleConditionSections() {
            if (conditionType.value === 'product') {
                productSection.style.display = 'block';
                categorySection.style.display = 'none';
            } else if (conditionType.value === 'category') {
                categorySection.style.display = 'block';
                productSection.style.display = 'none';
            } else {
                productSection.style.display = 'none';
                categorySection.style.display = 'none';
            }
        }

        conditionType.addEventListener('change', toggleConditionSections);
        toggleConditionSections(); // Kiểm tra lần đầu khi tải trang
    });

    function removeCondition(type, id, tagElement) {
        // Xóa thẻ điều kiện khỏi giao diện
        tagElement.remove();

        // Xóa input ẩn tương ứng
        const input = hiddenInputs.querySelector(`input[data-type="${type}"][data-id="${id}"]`);
        if (input) input.remove();

        // Xóa ID khỏi mảng đã chọn
        const array = type === 'product' ? selectedProducts : selectedCategories;
        array.splice(array.indexOf(id), 1);

        // Thêm lại option vào dropdown
        const select = type === 'product' ? productSelect : categorySelect;
        const option = document.createElement('option');
        option.value = id;

        // Lấy tên điều kiện để đưa vào dropdown (cắt bỏ phần "Xóa" từ thẻ điều kiện)
        const name = tagElement.textContent.replace('Xóa', '').trim();
        option.textContent = name;

        select.appendChild(option); // Thêm option vào dropdown
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const conditionType = document.getElementById('condition_type');
        const productSection = document.getElementById('product_section');
        const categorySection = document.getElementById('category_section');
        const productSelect = document.getElementById('product_select');
        const categorySelect = document.getElementById('category_select');
        const appliedConditions = document.getElementById('applied_conditions');
        const hiddenInputs = document.getElementById('hidden_inputs');

        let selectedProducts = [];
        let selectedCategories = [];

        // Lắng nghe thay đổi loại điều kiện
        conditionType.addEventListener('change', toggleFields);

        // Lắng nghe thay đổi lựa chọn sản phẩm/danh mục
        productSelect.addEventListener('change', handleSelectCondition);
        categorySelect.addEventListener('change', handleSelectCondition);

        // Hàm toggle để hiển thị các trường nhập liệu
        function toggleFields() {
            productSection.style.display = conditionType.value === 'product' ? 'block' : 'none';
            categorySection.style.display = conditionType.value === 'category' ? 'block' : 'none';
        }

        // Hàm xử lý việc chọn sản phẩm hoặc danh mục
        function handleSelectCondition() {
            const type = conditionType.value;
            const selectElement = type === 'product' ? productSelect : categorySelect;
            const selectedArray = type === 'product' ? selectedProducts : selectedCategories;

            Array.from(selectElement.selectedOptions).forEach(option => {
                // Thêm sản phẩm/danh mục nếu chưa có
                if (!selectedArray.includes(option.value)) {
                    selectedArray.push(option.value);
                    addAppliedCondition(type, option.value, option.text);
                    createHiddenInput(type, option.value);
                    option.remove(); // Xóa khỏi dropdown sau khi chọn
                }
            });
        }

        // Hàm thêm điều kiện đã chọn vào danh sách đã áp dụng
        function addAppliedCondition(type, id, name) {
            const tag = document.createElement('div');
            tag.className = 'badge bg-primary me-2 mt-2';
            tag.innerHTML = `${name} <button type="button" class="btn-close ms-2 remove-condition" data-type="${type}" data-id="${id}"></button>`;
            appliedConditions.appendChild(tag);

            // Xử lý sự kiện xóa điều kiện
            tag.querySelector('.remove-condition').addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                const id = this.getAttribute('data-id');
                removeCondition(type, id, tag);
            });
        }

        // Hàm tạo input ẩn để lưu các điều kiện đã chọn
        function createHiddenInput(type, id) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = type === 'product' ? 'product_ids[]' : 'category_ids[]';
            input.value = id;
            input.setAttribute('data-type', type);
            input.setAttribute('data-id', id);
            hiddenInputs.appendChild(input);
        }

        function removeCondition(type, id, tagElement) {
            // Xóa thẻ điều kiện khỏi giao diện
            tagElement.remove();

            // Xóa input ẩn tương ứng
            const input = hiddenInputs.querySelector(`input[data-type="${type}"][data-id="${id}"]`);
            if (input) input.remove();

            // Xóa ID khỏi mảng đã chọn
            const array = type === 'product' ? selectedProducts : selectedCategories;
            array.splice(array.indexOf(id), 1);

            // Thêm lại option vào dropdown
            const select = type === 'product' ? productSelect : categorySelect;
            const option = document.createElement('option');
            option.value = id;
            option.textContent = tagElement.textContent.trim().replace('Xóa', '').trim(); // Xử lý văn bản để loại bỏ nút xóa
            select.appendChild(option);
        }

        // Thêm sự kiện xóa cho nút xóa động
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-condition');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tagElement = this.closest('.applied-condition');
                    const type = tagElement.getAttribute('data-condition-type');
                    const id = this.getAttribute('data-id');
                    removeCondition(type, id, tagElement);
                });
            });
        });

    });
</script>
