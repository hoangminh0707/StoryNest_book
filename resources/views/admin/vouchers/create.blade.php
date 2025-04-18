@extends('admin.layouts.app')

@section('title', 'Thêm Mã Giảm Giá')

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

        <form action="{{ route('vouchers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="code" class="form-label">Mã giảm giá</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Tên chương trình</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Loại giảm giá</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Cố định (VND)</option>
                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Giá trị</label>
                <input type="number" name="value" id="value" class="form-control" value="{{ old('value') }}" required>
            </div>

            <div class="mb-3">
                <label for="max_discount_amount" class="form-label">Giảm giá tối đa (nếu là %)</label>
                <input type="number" name="max_discount_amount" id="max_discount_amount" class="form-control" value="{{ old('max_discount_amount') }}">
            </div>

            <div class="mb-3">
                <label for="min_order_value" class="form-label">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="min_order_value" id="min_order_value" class="form-control" value="{{ old('min_order_value') }}">
            </div>

            <div class="mb-3">
                <label for="expires_at" class="form-label">Ngày hết hạn</label>
                <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at') }}">
            </div>

            <div class="mb-3">
                <label for="max_usage" class="form-label">Số lần sử dụng tối đa</label>
                <input type="number" name="max_usage" id="max_usage" class="form-control" value="{{ old('max_usage') }}">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Kích hoạt</label>
            </div>

            <div class="mb-3">
                <label class="form-label">Điều kiện áp dụng</label>
                <div id="applied_conditions">
                    <!-- Thẻ điều kiện được thêm động tại đây -->
                </div>
            </div>

            <div class="mb-3">
                <label for="condition_type" class="form-label">Áp dụng cho</label>
                <select name="condition_type" id="condition_type" class="form-control">
                    <option value="">-- Tất cả sản phẩm --</option>
                    <option value="product">Sản phẩm</option>
                    <option value="category">Danh mục</option>
                </select>
            </div>

            <div class="mb-3" id="product_section" style="display: none;">
                <label class="form-label">Chọn sản phẩm</label>
                <select id="product_select" class="form-control" multiple>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3" id="category_section" style="display: none;">
                <label class="form-label">Chọn danh mục</label>
                <select id="category_select" class="form-control" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Hidden inputs để lưu điều kiện đã chọn -->
            <div id="hidden_inputs"></div>

            <button type="submit" class="btn btn-primary">Tạo voucher</button>
            <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conditionType = document.getElementById('condition_type');
        const productSection = document.getElementById('product_section');
        const categorySection = document.getElementById('category_section');
        const productSelect = document.getElementById('product_select');
        const categorySelect = document.getElementById('category_select');
        const appliedConditions = document.getElementById('applied_conditions');
        const hiddenInputs = document.getElementById('hidden_inputs');

        let selectedProducts = [];
        let selectedCategories = [];

        conditionType.addEventListener('change', () => {
            toggleFields();
        });

        productSelect.addEventListener('change', handleSelectCondition);
        categorySelect.addEventListener('change', handleSelectCondition);

        function toggleFields() {
            productSection.style.display = conditionType.value === 'product' ? 'block' : 'none';
            categorySection.style.display = conditionType.value === 'category' ? 'block' : 'none';
        }

        function handleSelectCondition() {
            const type = conditionType.value;
            const selectElement = type === 'product' ? productSelect : categorySelect;
            const selectedArray = type === 'product' ? selectedProducts : selectedCategories;

            Array.from(selectElement.selectedOptions).forEach(option => {
                if (!selectedArray.includes(option.value)) {
                    selectedArray.push(option.value);
                    addAppliedCondition(type, option.value, option.text);
                    createHiddenInput(type, option.value);
                    option.remove();  // Xóa khỏi dropdown
                }
            });
        }

        function addAppliedCondition(type, id, name) {
            const tag = document.createElement('div');
            tag.className = 'badge bg-primary me-2 mt-2';
            tag.innerHTML = `${name} <button type="button" class="btn-close ms-2 remove-condition" data-type="${type}" data-id="${id}"></button>`;
            appliedConditions.appendChild(tag);

            tag.querySelector('.remove-condition').addEventListener('click', function () {
                const type = this.getAttribute('data-type');
                const id = this.getAttribute('data-id');
                removeCondition(type, id, tag);
            });
        }

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
            tagElement.remove();

            const input = hiddenInputs.querySelector(`input[data-type="${type}"][data-id="${id}"]`);
            if (input) input.remove();

            const select = type === 'product' ? productSelect : categorySelect;
            const array = type === 'product' ? selectedProducts : selectedCategories;
            array.splice(array.indexOf(id), 1);

            // Thêm lại option
            const option = document.createElement('option');
            option.value = id;
            option.textContent = tagElement.textContent.trim();
            select.appendChild(option);
        }
    });
</script>
