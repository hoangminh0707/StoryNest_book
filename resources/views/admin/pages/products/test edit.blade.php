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
        <!-- tên sp  -->
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="form-control"
                required>
        </div>

        <!-- Thẻ chọn danh mục -->
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





        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection


<!-- danh mục -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        select.addEventListener('change', function() {
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
        tagContainer.addEventListener('click', function(e) {
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