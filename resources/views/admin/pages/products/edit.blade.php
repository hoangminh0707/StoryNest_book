@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
    <div class="container">
        <h1 class="mb-4">Chỉnh sửa sản phẩm</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            id="productForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control"
                    required>
            </div>

            <!-- <div class="mb-3">
                <label for="product_type" class="form-label">Loại sản phẩm</label>
                <select name="product_type" id="product_type" class="form-select" required>
                    <option value="simple" {{ old('product_type', $product->product_type) === 'simple' ? 'selected' : '' }}>Sản phẩm đơn giản</option>
                    <option value="variable" {{ old('product_type', $product->product_type) === 'variable' ? 'selected' : '' }}>Sản phẩm biến thể</option>
                </select>
            </div>

            <div id="simpleFields" style="{{ old('product_type', $product->product_type) === 'simple' ? '' : 'display:none;' }}">
                <div class="mb-3">
                    <label for="price" class="form-label">Giá</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" class="form-control">
                </div>
            </div> -->

            {{-- Dropdown chọn danh mục --}}
            <div class="mb-4">
                <label for="category_select" class="form-label">Danh Mục <span class="text-danger">*</span></label>
                <select id="category_select" class="form-select">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        @if(!in_array($category->id, $selectedCategoryIds))
                            <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                {{ $category->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Thẻ danh mục đã chọn --}}
            <div class="mb-3" id="selected-categories">
                @foreach($categories->whereIn('id', $selectedCategoryIds) as $cat)
                    <div class="category-tag" data-id="{{ $cat->id }}">
                        {{ $cat->name }}
                        <span class="remove-tag" data-id="{{ $cat->id }}">&times;</span>
                    </div>
                @endforeach
            </div>

            {{-- Input ẩn để submit --}}
            <input type="hidden" name="category_ids" id="category_ids_input"
                value="{{ json_encode($selectedCategoryIds) }}">


            <div class="mb-3">
                <label for="author_id" class="form-label">Tác giả</label>
                <select name="author_id" id="author_id" class="form-select">
                    <option value="">-- Chọn tác giả --</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('author_id', $product->author_id) == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="publisher_id" class="form-label">Nhà xuất bản</label>
                <select name="publisher_id" id="publisher_id" class="form-select">
                    <option value="">-- Chọn nhà xuất bản --</option>
                    @foreach($publishers as $publisher)
                        <option value="{{ $publisher->id }}" {{ old('publisher_id', $product->publisher_id) == $publisher->id ? 'selected' : '' }}>
                            {{ $publisher->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select" required>
                    <option value="published" {{ $product->status === 'published' ? 'selected' : '' }}>Công khai</option>
                    <option value="draft" {{ $product->status === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                </select>
            </div>

            {{-- Ảnh chính (Thumbnail) --}}
            <div class="mb-4">
                <label for="thumbnail-input" class="form-label fw-bold">
                    Ảnh chính <span class="text-danger">*</span>
                </label>

                {{-- Thumbnail hiện tại --}}
                @php $thumb = $product->images->where('is_thumbnail', true)->first(); @endphp
                <div id="current-thumbnail" class="mb-3">
                    @if($thumb)
                        <img src="{{ asset($thumb->image_path) }}" alt="Thumbnail hiện tại" width="120" class="rounded border">
                    @endif
                </div>
                {{-- Preview ảnh chính mới --}}
                <div class="mb-3" id="thumbnail-preview"></div>

                {{-- Chọn thumbnail mới --}}
                <input type="file" name="thumbnail" id="thumbnail-input" class="form-control" accept="image/*">


            </div>

            {{-- Ảnh phụ (Gallery) --}}
            <div class="mb-4">
                <label for="gallery-input" class="form-label fw-bold">Ảnh phụ</label>

                {{-- Ảnh phụ hiện tại --}}
                @php $gallery = $product->images->where('is_thumbnail', false); @endphp
                <div class="d-flex flex-wrap gap-3" id="current-gallery">
                    @foreach($gallery as $img)
                        <div class="position-relative" id="gallery-item-{{ $img->id }}">
                            <img src="{{ asset($img->image_path) }}" width="100" class="rounded border">
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                onclick="removeGalleryImage({{ $img->id }})">
                                &times;
                            </button>
                            <!-- <input type="hidden" name="delete_gallery[]" value="{{ $img->id }}" id="delete-input-{{ $img->id }}"> -->
                        </div>
                    @endforeach
                </div>
                {{-- Preview ảnh phụ mới --}}
                <div class="m-3 d-flex flex-wrap gap-3" id="gallery-preview"></div>
                {{-- Chọn ảnh phụ mới --}}
                <input type="file" name="gallery[]" id="gallery-input" class="form-control mt-3" accept="image/*" multiple>
            </div>




            <div class="mb-4">
                <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                <select name="status" class="form-control" required>
                    <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Đã xuất
                        bản</option>
                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Nháp</option>
                </select>
            </div>

            <!-- Loại sản phẩm (Đơn / Biến thể) -->
            <div class="mb-4">
                <label for="product_type" class="form-label">Loại Sản Phẩm <span class="text-danger">*</span></label>
                <select name="product_type" id="product_type" class="form-select" required>
                    <option value="simple" {{ old('product_type', $product->product_type) == 'simple' ? 'selected' : '' }}>Đơn
                    </option>
                    <option value="variable" {{ old('product_type', $product->product_type) == 'variable' ? 'selected' : '' }}>Biến thể</option>
                </select>
            </div>

            <!-- Khi chọn loại 'variable' -->
            <div id="variable-section"
                style="display: {{ old('product_type', $product->product_type) == 'variable' ? 'block' : 'none' }};">
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

                <div id="variable-result-section"
                    style="display: {{ old('product_type', $product->product_type) == 'variable' && ($product->variants->count() || old('variants')) ? 'block' : 'none' }};">
                    <h5 class="mt-4">Danh sách biến thể</h5>
                    <div id="variable-list" class="space-y-3">
                        @if(old('variants') || $product->variants->count())
                                        @foreach(old('variants', $product->variants) as $index => $variant)
                                                        <div class="row align-items-center mb-2">
                                                            <div class="col-md-4">
                                                                <strong>
                                                                    @php
                                                                        // Kiểm tra xem variant có phải là mảng không
                                                                        if (is_array($variant)) {
                                                                            $variantName = implode(' - ', array_map(function ($valueId) {
                                                                                return \App\Models\AttributeValue::find($valueId)->value ?? 'N/A';
                                                                            }, $variant['attribute_values']));
                                                                        } else {
                                                                            // Nếu là đối tượng, lấy tên biến thể
                                                                            $variantName = $variant->attributeValues->pluck('value')->implode(' - ');
                                                                        }
                                                                    @endphp
                                                                    {{ $variantName }}
                                                                </strong>
                                                                @if(!is_array($variant))
                                                                    @foreach($variant->attributeValues ?? [] as $value)
                                                                        <input type="hidden" name="variants[{{ $index }}][attribute_values][]"
                                                                            value="{{ $value->id }}">
                                                                    @endforeach
                                                                @else
                                                                    @foreach($variant['attribute_values'] as $valueId)
                                                                        <input type="hidden" name="variants[{{ $index }}][attribute_values][]"
                                                                            value="{{ $valueId }}">
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="number" name="variants[{{ $index }}][variant_price]" class="form-control"
                                                                    placeholder="Giá"
                                                                    value="{{ old("variants.$index.variant_price", is_array($variant) ? ($variant['variant_price'] ?? '') : $variant->variant_price) }}">

                                                            </div>

                                                            <div class="col-md-2">
                                                                <input type="number" name="variants[{{ $index }}][stock_quantity]" class="form-control" placeholder="SL"
                                                                    value="{{ old("variants.$index.stock_quantity", is_array($variant) ? ($variant['stock_quantity'] ?? '') : $variant->stock_quantity) }}">
                                                            </div>

                                                        </div>
                                        @endforeach
                        @endif
                    </div>
                </div>

            </div>

            <!-- Khi chọn loại 'simple' -->
            <div id="price-quantity-section"
                style="display: {{ old('product_type', $product->product_type) == 'simple' ? 'block' : 'none' }};">
                <div class="mb-4">
                    <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="form-control"
                        value="{{ old('price', $product->price) }}" min="0" placeholder="Nhập giá sản phẩm">
                </div>
                <div class="mb-4">
                    <label for="quantity" class="form-label">Số Lượng <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                        value="{{ old('quantity', $product->quantity) }}" min="0" placeholder="Nhập số lượng sản phẩm">
                </div>
            </div>


            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const typeSelect = document.getElementById('product_type');
        const simpleFields = document.getElementById('simpleFields');
        const variantFields = document.getElementById('variantFields');

        function toggleFields() {
            if (typeSelect.value === 'simple') {
                simpleFields.style.display = 'block';
                variantFields.style.display = 'none';
            } else {
                simpleFields.style.display = 'none';
                variantFields.style.display = 'block';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Init
    });


    document.addEventListener("DOMContentLoaded", function () {
        // Ảnh chính
        const thumbnailInput = document.getElementById('thumbnail-input');
        const thumbnailPreview = document.getElementById('thumbnail-preview');

        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', function (e) {
                thumbnailPreview.innerHTML = '';
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.width = 120;
                        img.className = 'rounded border';
                        thumbnailPreview.appendChild(img);
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        }

        // Ảnh phụ
        const galleryInput = document.getElementById('gallery-input');
        const galleryPreview = document.getElementById('gallery-preview');

        if (galleryInput) {
            galleryInput.addEventListener('change', function (e) {
                galleryPreview.innerHTML = '';
                const files = e.target.files;
                for (let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.width = 100;
                        img.className = 'rounded border me-2 mb-2';
                        galleryPreview.appendChild(img);
                    };
                    reader.readAsDataURL(files[i]);
                }
            });
        }
    });

    // Xóa ảnh phụ hiện tại
    function removeGalleryImage(id) {
        const item = document.getElementById('gallery-item-' + id);
        if (item) {
            const img = item.querySelector('img');
            if (img) img.style.opacity = '0.4';

            const button = item.querySelector('button');
            if (button) {
                button.innerText = 'Đã chọn xóa';
                button.classList.remove('btn-danger');
                button.classList.add('btn-secondary');
                button.disabled = true;
            }

            // Tạo input hidden để gửi ID ảnh cần xóa
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'delete_gallery[]';
            hiddenInput.value = id;
            hiddenInput.id = 'delete-input-' + id;
            item.appendChild(hiddenInput);

        }
    }

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const select = document.getElementById('category_select');
        const tagContainer = document.getElementById('selected-categories');
        const hiddenInput = document.getElementById('category_ids_input');

        // Khởi tạo danh mục đã chọn từ input ẩn
        let selectedCategories = [];
        try {
            selectedCategories = JSON.parse(hiddenInput.value) || [];
        } catch (e) {
            selectedCategories = [];
        }

        // Cập nhật lại hidden input
        function updateHiddenInput() {
            hiddenInput.value = JSON.stringify(selectedCategories);
        }

        // Tạo thẻ danh mục hiển thị
        function createCategoryTag(id, name) {
            const tag = document.createElement('div');
            tag.className = 'category-tag';
            tag.dataset.id = id;
            tag.innerHTML = `
                ${name}
                <span class="remove-tag" data-id="${id}">&times;</span>
            `;
            tagContainer.appendChild(tag);
        }

        // Khi chọn từ dropdown
        select.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const id = selectedOption.value;
            const name = selectedOption.dataset.name;

            if (id && !selectedCategories.includes(id)) {
                selectedCategories.push(id);
                createCategoryTag(id, name);
                selectedOption.remove();
                updateHiddenInput();
            }

            this.selectedIndex = 0;
        });

        // Xử lý xoá thẻ danh mục
        tagContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-tag')) {
                const id = e.target.dataset.id;
                const tag = e.target.closest('.category-tag');
                const name = tag.textContent.trim().replace('×', '');

                // Xoá khỏi mảng
                selectedCategories = selectedCategories.filter(item => item !== id);

                // Xoá khỏi DOM
                tag.remove();

                // Thêm lại option vào select
                const option = document.createElement('option');
                option.value = id;
                option.text = name;
                option.dataset.name = name;
                select.appendChild(option);

                // Sắp xếp lại dropdown
                const options = Array.from(select.options).slice(1); // Bỏ option đầu
                options.sort((a, b) => a.text.localeCompare(b.text));
                options.forEach(opt => select.appendChild(opt));

                updateHiddenInput();
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const productTypeSelect = document.getElementById('product_type');
        const variableSection = document.getElementById('variable-section');
        const simpleSection = document.getElementById('price-quantity-section');
        const variableResultSection = document.getElementById('variable-result-section');
        const variableList = document.getElementById('variable-list');

        let selectedValues = {}; // { attributeId: [{ id, name }, ...] }

        // --- GÁN SẴN KHI SỬA ---
        const currentType = productTypeSelect.value;
        toggleProductType(currentType);

        // Xử lý thay đổi loại sản phẩm
        productTypeSelect.addEventListener('change', function () {
            toggleProductType(this.value);
        });

        function toggleProductType(type) {
            if (type === 'variable') {
                variableSection.style.display = 'block';
                simpleSection.style.display = 'none';
            } else if (type === 'simple') {
                variableSection.style.display = 'none';
                simpleSection.style.display = 'block';
                variableResultSection.style.display = 'none';
                variableList.innerHTML = '';
            } else {
                variableSection.style.display = 'none';
                simpleSection.style.display = 'none';
                variableResultSection.style.display = 'none';
                variableList.innerHTML = '';
            }
        }

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

                generateVariables();
            });
        });

        // Hàm tạo tổ hợp biến thể
        function generateVariables() {
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
                    <strong>${comboText}</strong>
                    ${hiddenInputs}
                </div>
               
                <div class="col-md-2">
                    <input type="number" name="variants[${index}][variant_price]" class="form-control" placeholder="Giá">
                </div>
                <div class="col-md-2">
                    <input type="number" name="variants[${index}][stock_quantity]" class="form-control" placeholder="SL">
                </div>
            `;
                variableList.appendChild(row);
            });

            variableResultSection.style.display = 'block';
        }

        // Hàm tạo tổ hợp từ các thuộc tính đã chọn
        function getCombinations(attributeEntries) {
            const result = [];

            function recurse(index, currentCombo) {
                if (index === attributeEntries.length) {
                    result.push(currentCombo);
                    return;
                }

                const [_, values] = attributeEntries[index];
                values.forEach(value => {
                    recurse(index + 1, [...currentCombo, value]);
                });
            }

            recurse(0, []);
            return result;
        }
        if (variableListHasItems()) {
            variableResult.style.display = 'block';
        }
    });
</script>


<style>
    .category-tag {
        display: inline-block;
        padding: 5px 10px;
        margin: 4px;
        background-color: #e9ecef;
        border-radius: 20px;
        font-size: 14px;
        position: relative;
    }

    .remove-tag {
        margin-left: 8px;
        cursor: pointer;
        color: red;
        font-weight: bold;
    }
</style>