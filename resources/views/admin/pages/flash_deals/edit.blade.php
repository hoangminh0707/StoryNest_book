@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa Flash Deal')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0 text-primary fw-bold">Chỉnh sửa Flash Deal</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.flash_deals.update', $flashDeal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $flashDeal->title) }}" placeholder="Nhập tiêu đề flash deal">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="start_time" class="form-label fw-semibold">Thời gian bắt đầu <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="start_time" id="start_time"
                                class="form-control @error('start_time') is-invalid @enderror"
                                value="{{ old('start_time', \Carbon\Carbon::parse($flashDeal->start_time)->format('Y-m-d\TH:i')) }}">
                            @error('start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="end_time" class="form-label fw-semibold">Thời gian kết thúc <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="end_time" id="end_time"
                                class="form-control @error('end_time') is-invalid @enderror"
                                value="{{ old('end_time', \Carbon\Carbon::parse($flashDeal->end_time)->format('Y-m-d\TH:i')) }}">
                            @error('end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="discount_percent" class="form-label fw-semibold">
                            Phần trăm giảm giá (%) <span class="text-danger">*</span>
                        </label>
                        <input
                            type="number"
                            name="discount_percent"
                            id="discount_percent"
                            class="form-control @error('discount_percent') is-invalid @enderror"
                            value="{{ old('discount_percent', $flashDeal->flashSaleVariants->first() ? round((1 - $flashDeal->flashSaleVariants->first()->discount_price / $flashDeal->flashSaleVariants->first()->productVariant->variant_price) * 100) : '') }}"
                            placeholder="Nhập % giảm giá"
                        >
                        @error('discount_percent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                 <div class="mb-3">
                    <label for="usage_limit" class="form-label fw-semibold">
                            Giới hạn số lần sử dụng
                            <small class="text-muted">(Có thể để trống nếu không giới hạn)</small>
                        </label>
                        <input
                            type="text"
                            name="usage_limit"
                            id="usage_limit"
                            class="form-control @error('usage_limit') is-invalid @enderror"
                            value="{{ old('usage_limit', $flashDeal->usage_limit) }}"
                            placeholder="Nhập số lần sử dụng tối đa">
                        @error('usage_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="product_id" class="form-label fw-semibold">Sản phẩm <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror">
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id', $flashDeal->flashSaleVariants->first()->productVariant->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('product_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div id="variant-label-group">
                            <label class="form-label fw-semibold">Biến thể sản phẩm <span class="text-danger">*</span></label>
                            <div class="form-text mb-1">Chọn ít nhất một biến thể áp dụng flash deal</div>
                        </div>

                        <div id="variant-container"
                            class="border rounded p-2 @error('variant_ids') is-invalid @enderror"
                            style="max-height: 180px; overflow-y: auto;">

                            @php
                                $selectedVariantIds = old('variant_ids', $flashDeal->flashSaleVariants->pluck('product_variant_id')->toArray());
                            @endphp

                            @if(!empty($variants) && count($variants) > 0)
                                @foreach($variants as $variant)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        name="variant_ids[]"
                                        id="variant_{{ $variant->id }}"
                                        value="{{ $variant->id }}"
                                        {{ in_array($variant->id, $selectedVariantIds) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="variant_{{ $variant->id }}">
                                        {{ $variant->variant_name ?? ($variant->attributeValues->map(fn($v) => $v->attribute->name . ': ' . $v->value)->implode(' - ') ?: 'Biến thể không rõ') }} - Giá: {{ number_format($variant->variant_price, 0, ',', '.') }} đ

                                    </label>
                                </div>
                                @endforeach
                            @else
                                <small class="text-muted">Vui lòng chọn sản phẩm trước để tải biến thể.</small>
                            @endif
                        </div>

                        @error('variant_ids')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('variant_ids.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.flash_deals.index') }}" class="btn btn-secondary me-2">Hủy</a>
                        <button type="submit" class="btn btn-primary">Cập nhật Flash Deal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- JS tải biến thể --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');
        const variantContainer = document.getElementById('variant-container');
        const variantLabelGroup = document.getElementById('variant-label-group');

        function toggleVariantLabel(show) {
            if (show) {
                variantLabelGroup.style.display = 'block';
            } else {
                variantLabelGroup.style.display = 'none';
            }
        }

        productSelect.addEventListener('change', function() {
            const productId = this.value;
            variantContainer.innerHTML = '';
            toggleVariantLabel(false);

            if (!productId) {
                variantContainer.innerHTML = '<small class="text-muted">Vui lòng chọn sản phẩm trước để tải biến thể.</small>';
                return;
            }

            fetch('{{ route("admin.flash_deals.getVariants") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.length) {
                        variantContainer.innerHTML = '<p class="text-muted fst-italic">Không có biến thể nào cho sản phẩm này.</p>';
                        toggleVariantLabel(false);
                        return;
                    }

                    let html = '<div class="form-check mb-2"><input type="checkbox" class="form-check-input" id="check-all"><label class="form-check-label fw-semibold" for="check-all">Chọn tất cả</label></div>';
                    data.forEach(variant => {
                        html += `
                    <div class="form-check">
                        <input class="form-check-input variant-checkbox" type="checkbox" name="variant_ids[]" value="${variant.id}" id="variant_${variant.id}">
                        <label class="form-check-label" for="variant_${variant.id}">${variant.name} - Giá gốc: <strong>${Number(variant.price).toLocaleString('vi-VN')} đ</strong></label>
                    </div>`;
                    });

                    variantContainer.innerHTML = html;
                    toggleVariantLabel(true);

                    const checkAll = document.getElementById('check-all');
                    checkAll.addEventListener('change', function() {
                        const checkboxes = variantContainer.querySelectorAll('.variant-checkbox');
                        checkboxes.forEach(cb => cb.checked = this.checked);
                    });
                })
                .catch(() => {
                    variantContainer.innerHTML = '<p class="text-danger fw-semibold">Lỗi tải biến thể, vui lòng thử lại.</p>';
                    toggleVariantLabel(false);
                });
        });

        // Nếu có giá trị old product_id thì tự động load lại biến thể
        @if(old('product_id'))
        productSelect.dispatchEvent(new Event('change'));
        @endif
    });
</script>
@endsection
