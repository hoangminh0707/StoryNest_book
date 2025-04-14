@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Thêm Sản Phẩm</h4>
        </div>
    </div>
</div>

<!-- Hiển thị lỗi nếu có -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Form thêm sản phẩm -->
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-body">

            <!-- Tên sản phẩm -->
            <div class="mb-4">
                <label for="name" class="form-label">Tên Sản Phẩm <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name') }}" placeholder="Nhập tên sản phẩm" required>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="mb-4">
                <label for="description" class="form-label">Mô Tả Sản Phẩm <span class="text-danger">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="4"
                    placeholder="Mô tả sản phẩm của bạn như thế nào? Hãy sáng tạo và hấp dẫn!" required>{{ old('description') }}</textarea>
                <div class="text-end">
                    <small id="charCount" class="text-muted">0/300 ký tự</small>
                </div>
            </div>

            <!-- Danh mục sản phẩm -->
            <div class="mb-4">
                <label for="category_id" class="form-label">Danh Mục <span class="text-danger">*</span></label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Tác giả -->
            <div class="mb-4">
                <label for="author_id" class="form-label">Tác Giả</label>
                <select name="author_id" id="author_id" class="form-select" required>
                    <option value="">-- Chọn tác giả --</option>
                    @foreach ($authors as $author)
                    <option value="{{ $author->id }}"
                        {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Nhà xuất bản -->
            <div class="mb-4">
                <label for="publisher_id" class="form-label">Nhà Xuất Bản</label>
                <select name="publisher_id" id="publisher_id" class="form-select" required>
                    <option value="">-- Chọn nhà xuất bản --</option>
                    @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}"
                        {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                        {{ $publisher->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div class="mb-4">
                <label for="images" class="form-label">Hình Ảnh</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple>
                <small class="text-muted">Tải lên nhiều hình ảnh cho sản phẩm (JPEG, PNG, GIF, SVG)</small>
            </div>

            <div class="mb-4">
            <label for="publisher_id" class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                </select>
            </div>

            <!-- Loại sản phẩm (Đơn / Biến thể) -->
            <div class="mb-4">
                <label for="product_type" class="form-label">Loại Sản Phẩm <span class="text-danger">*</span></label>
                <select name="product_type" id="product_type" class="form-select" required>
                    <option value="">-- Chọn loại sản phẩm --</option>
                    <option value="simple" {{ old('product_type') == 'simple' ? 'selected' : '' }}>Đơn</option>
                    <option value="variable" {{ old('product_type') == 'variable' ? 'selected' : '' }}>Biến thể</option>
                </select>
            </div>

            <!-- Khi chọn loại 'variable' -->
            <div id="variable-section" style="display: none;">
                <div id="variable-selector">
                    @foreach($attributes as $attribute)
                    <div class="mb-3">
                        <label class="form-label">{{ $attribute->name }}</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($attribute->values as $value)
                            <button type="button"
                                class="btn btn-outline-primary btn-sm attribute-value-btn"
                                data-attribute-id="{{ $attribute->id }}"
                                data-attribute-name="{{ $attribute->name }}"
                                data-value-id="{{ $value->id }}"
                                data-value-name="{{ $value->value }}">
                                {{ $value->value }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <div id="variable-result-section" style="display: none;">
                    <h5 class="mt-4">Danh sách biến thể</h5>
                    <div id="variable-list"></div>
                </div>
            </div>

            <!-- Khi chọn loại 'simple' -->
            <div id="price-quantity-section" style="display: none;">
                <div class="mb-4">
                    <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="form-control"
                        value="{{ old('price') }}" min="0" placeholder="Nhập giá sản phẩm">
                </div>
                <div class="mb-4">
                    <label for="quantity" class="form-label">Số Lượng <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        value="{{ old('quantity') }}" min="0" placeholder="Nhập số lượng sản phẩm">
                </div>
            </div>



        </div>

        <!-- Nút gửi và hủy -->
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-success">Lưu</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Hủy</a>
        </div>
    </div>
</form>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const productTypeSelect = document.getElementById('product_type');
        const variableSection = document.getElementById('variable-section');
        const simpleSection = document.getElementById('price-quantity-section');
        const variableResultSection = document.getElementById('variable-result-section');
        const variableList = document.getElementById('variable-list');

        let selectedValues = {}; // { attributeId: [valueId, ...] }

        // Khi chọn loại sản phẩm
        productTypeSelect.addEventListener('change', function() {
            const value = this.value;
            if (value === 'variable') {
                variableSection.style.display = 'block';
                simpleSection.style.display = 'none';
            } else if (value === 'simple') {
                variableSection.style.display = 'none';
                simpleSection.style.display = 'block';
                variableList.innerHTML = '';
                variableResultSection.style.display = 'none';
            } else {
                variableSection.style.display = 'none';
                simpleSection.style.display = 'none';
                variableList.innerHTML = '';
                variableResultSection.style.display = 'none';
            }
        });

        // Xử lý chọn/deselect giá trị thuộc tính
        document.querySelectorAll('.attribute-value-btn').forEach(button => {
            button.addEventListener('click', function() {
                const attrId = this.dataset.attributeId;
                const valId = this.dataset.valueId;
                const valName = this.dataset.valueName;

                this.classList.toggle('active');

                if (!selectedValues[attrId]) {
                    selectedValues[attrId] = [];
                }

                if (this.classList.contains('active')) {
                    selectedValues[attrId].push({
                        id: valId,
                        name: valName
                    });
                } else {
                    selectedValues[attrId] = selectedValues[attrId].filter(v => v.id !== valId);
                    if (selectedValues[attrId].length === 0) {
                        delete selectedValues[attrId];
                    }
                }

                generatevariables(); // Gọi sau mỗi lần chọn/deselect
            });
        });

        // Hàm sinh các tổ hợp biến thể
        function generatevariables() {
            variableList.innerHTML = '';
            const entries = Object.entries(selectedValues);
            if (entries.length === 0 || entries.some(([_, vals]) => vals.length === 0)) {
                variableResultSection.style.display = 'none';
                return;
            }

            const combinations = getCombinations(entries);

            combinations.forEach((combo, index) => {
                const comboText = combo.map(item => item.name).join(' - ');
                const hiddenInputs = combo.map(item =>
                    `<input type="hidden" name="variants[${index}][attribute_values][]" value="${item.id}">`
                ).join('');

                const row = document.createElement('div');
                row.classList.add('row', 'align-items-center', 'mb-2');
                row.innerHTML = `
                    <div class="col-md-4">
                        ${comboText}
                        ${hiddenInputs}
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="variants[${index}][variant_price]" class="form-control" placeholder="Giá" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="variants[${index}][stock_quantity]" class="form-control" placeholder="Số lượng" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-variable">Xóa</button>
                    </div>
                `;
                variableList.appendChild(row);
            });

            variableResultSection.style.display = 'block';
        }

        // Hàm lấy tất cả tổ hợp từ các mảng
        function getCombinations(entries) {
            const result = [];

            function helper(index, currentCombo) {
                if (index === entries.length) {
                    result.push(currentCombo);
                    return;
                }

                const [_, values] = entries[index];
                values.forEach(value => {
                    helper(index + 1, [...currentCombo, value]);
                });
            }

            helper(0, []);
            return result;
        }

        // Xóa dòng biến thể
        variableList.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-variable')) {
                e.target.closest('.row').remove();
                // Nếu không còn dòng nào thì ẩn
                if (variableList.children.length === 0) {
                    variableResultSection.style.display = 'none';
                }
            }
        });
    });
</script>








@endsection