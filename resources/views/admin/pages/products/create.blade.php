@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')

@section('content')

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
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">

                <!-- Tên sản phẩm -->
                <div class="mb-4">
                    <label for="name" class="form-label">Tên Sản Phẩm <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Nhập tên sản phẩm" required>
                </div>

                <!-- Mô tả sản phẩm -->
                <div class="mb-4">
                    <label for="description" class="form-label">Mô Tả Sản Phẩm <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control" rows="4"
                        placeholder="Mô tả sản phẩm của bạn như thế nào? Hãy sáng tạo và hấp dẫn!"
                        required>{{ old('description') }}</textarea>
                    <div class="text-end">
                        <small id="charCount" class="text-muted">0/300 ký tự</small>
                    </div>
                </div>

                <!-- Danh mục sản phẩm -->
                @php
                    // Hàm đệ quy render option
                    function renderCategoryOptions($cats, $level = 0)
                    {
                        foreach ($cats as $c) {
                            $indent = str_repeat('— ', $level);
                            echo "<option value=\"{$c->id}\" data-parent=\"{$c->parent_id}\">"
                                . $indent . e($c->name) .
                                "</option>";
                            if ($c->childrenRecursive->count()) {
                                renderCategoryOptions($c->childrenRecursive, $level + 1);
                            }
                        }
                    }
                @endphp

                <div class="mb-2 d-flex justify-content-between align-items-center">
                    <label class="form-label mb-0">Danh mục</label>
                    <small id="selected-count" class="text-muted">Đã chọn: 0</small>
                </div>

                <div class="mb-4">
                    <select id="category_select" class="form-select" name="category_ids[]">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $root)
                            @php renderCategoryOptions(collect([$root])); @endphp
                        @endforeach
                    </select>
                </div>

                {{-- Nơi hiển thị tag đã chọn --}}
                <div class="mb-3 d-flex flex-wrap gap-2" id="selected-categories"></div>

                {{-- Input ẩn để submit --}}
                <input type="hidden" name="category_ids" id="category_ids_input" value="[]">


                <!-- Khu vực hiển thị thẻ danh mục đã chọn -->
                <div class="mb-3" id="selected-categories">
                    {{-- Thẻ danh mục sẽ được thêm động tại đây --}}
                </div>





                <!-- Tác giả -->
                <div class="mb-4">
                    <label for="author_id" class="form-label">Tác Giả</label>
                    <select name="author_id" id="author_id" class="form-select">
                        <option value="">-- Chọn tác giả --</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nhà xuất bản -->
                <div class="mb-4">
                    <label for="publisher_id" class="form-label">Nhà Xuất Bản</label>
                    <select name="publisher_id" id="publisher_id" class="form-select">
                        <option value="">-- Chọn nhà xuất bản --</option>
                        @foreach ($publishers as $publisher)
                            <option value="{{ $publisher->id }}" {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                                {{ $publisher->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hình ảnh sản phẩm -->
                <!-- Ảnh chính (Thumbnail) -->
                <div class="mb-4">
                    <label for="thumbnail-input" class="form-label fw-bold">Ảnh chính <span
                            class="text-danger">*</span></label>
                    <input type="file" name="thumbnail" id="thumbnail-input" class="form-control" accept="image/*" required>
                    <div class="mt-3 d-flex flex-wrap gap-3" id="thumbnail-preview"></div>
                </div>

                <!-- Ảnh phụ (Gallery) -->
                <div class="mb-4">
                    <label for="gallery-input" class="form-label fw-bold">Ảnh phụ</label>
                    <input type="file" name="gallery[]" id="gallery-input" class="form-control" accept="image/*" multiple>
                    <div class="mt-3 d-flex flex-wrap gap-3" id="gallery-preview"></div>
                </div>


                <div class="mb-4">
                    <label for="publisher_id" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản
                        </option>
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
                                        <button type="button" class="btn btn-outline-primary btn-sm attribute-value-btn"
                                            data-attribute-id="{{ $attribute->id }}" data-attribute-name="{{ $attribute->name }}"
                                            data-value-id="{{ $value->id }}" data-value-name="{{ $value->value }}">
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
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" min="1"
                            placeholder="Nhập giá sản phẩm">
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="form-label">Số Lượng <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" class="form-control"
                            value="{{ old('quantity') }}" min="1" placeholder="Nhập số lượng sản phẩm">
                    </div>
                </div>
            </div>

            <!-- Nút gửi và hủy -->
            <div class="card-footer ">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </div>
    </form>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const productTypeSelect = document.getElementById('product_type');
            const variableSection = document.getElementById('variable-section');
            const simpleSection = document.getElementById('price-quantity-section');
            const variableResultSection = document.getElementById('variable-result-section');
            const variableList = document.getElementById('variable-list');

            let selectedValues = {}; // { attributeId: [valueId, ...] }

            // Khi chọn loại sản phẩm
            productTypeSelect.addEventListener('change', function () {
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
                button.addEventListener('click', function () {
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
            variableList.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-variable')) {
                    e.target.closest('.row').remove();
                    // Nếu không còn dòng nào thì ẩn
                    if (variableList.children.length === 0) {
                        variableResultSection.style.display = 'none';
                    }
                }
            });
        });
        // Xem trước ảnh chính
        document.getElementById('thumbnail-input').addEventListener('change', function (e) {
            const preview = document.getElementById('thumbnail-preview');
            preview.innerHTML = '';
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    preview.innerHTML = `
                                            <div class="card shadow-sm" style="width: 150px;">
                                                <img src="${evt.target.result}" class="card-img-top" alt="Thumbnail">
                                            </div>
                                        `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Xem trước ảnh gallery
        document.getElementById('gallery-input').addEventListener('change', function (e) {
            const preview = document.getElementById('gallery-preview');
            preview.innerHTML = '';
            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    const div = document.createElement('div');
                    div.className = 'card shadow-sm';
                    div.style.width = '150px';
                    div.innerHTML = `<img src="${evt.target.result}" class="card-img-top" alt="Gallery">`;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
    <!-- danh mục  -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectEl = document.getElementById('category_select');
            const wrapper = document.getElementById('selected-categories');
            const hidden = document.getElementById('category_ids_input');
            const counter = document.getElementById('selected-count');

            let selected = []; // lúc tạo mới, chưa chọn gì

            function refreshUI() {
                wrapper.innerHTML = '';
                selectEl.querySelectorAll('option').forEach(o => o.hidden = false);

                selected.forEach(id => {
                    const opt = selectEl.querySelector(`option[value="${id}"]`);
                    if (!opt) return;
                    // ẩn option
                    opt.hidden = true;

                    // tạo tag
                    const tag = document.createElement('div');
                    tag.className = 'badge bg-primary d-inline-flex align-items-center me-1 mb-1';
                    tag.dataset.id = id;
                    tag.innerHTML = `
                                ${opt.textContent.trim()}
                                <button type="button" class="btn-close btn-close-white ms-2"
                                        aria-label="Remove" data-id="${id}"
                                        style="font-size:.7rem;"></button>
                              `;
                    wrapper.appendChild(tag);
                });

                hidden.value = JSON.stringify(selected);
                counter.innerText = `Đã chọn: ${selected.length}`;
            }

            // Chọn option
            selectEl.addEventListener('change', e => {
                const id = e.target.value;
                if (!id || selected.includes(id)) return;

                // thêm chính nó
                selected.push(id);
                // auto chọn con
                selectEl.querySelectorAll('option').forEach(opt => {
                    if (opt.dataset.parent == id && !selected.includes(opt.value)) {
                        selected.push(opt.value);
                    }
                });

                selectEl.selectedIndex = 0;
                refreshUI();
            });

            // Xóa tag (cha→xóa con đệ quy)
            wrapper.addEventListener('click', e => {
                if (!e.target.matches('.btn-close')) return;
                const id = e.target.dataset.id;

                function removeRecursively(remId) {
                    selected = selected.filter(x => x != remId);
                    selectEl.querySelectorAll('option').forEach(opt => {
                        if (opt.dataset.parent == remId) {
                            removeRecursively(opt.value);
                        }
                    });
                }

                removeRecursively(id);
                refreshUI();
            });

            // Khởi tạo UI (mặc dù selected==[])
            refreshUI();
        });
    </script>

    <style>
        .category-tag {
            display: inline-block;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 5px 10px;
            margin: 5px 5px 0 0;
            font-size: 14px;
            position: relative;
        }

        .category-tag .remove-tag {
            margin-left: 8px;
            cursor: pointer;
            color: red;
            font-weight: bold;
        }
    </style>

@endsection