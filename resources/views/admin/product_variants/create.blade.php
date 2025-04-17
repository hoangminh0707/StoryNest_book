@extends('admin.layouts.app')
@section('title', 'Thêm Biến Thể Sản Phẩm')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Thêm Biến Thể Sản Phẩm</h4>
                <a href="{{ route('product_variants.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Quay lại
                </a>
            </div>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('product_variants.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Sản phẩm</label>
                            <select name="product_id" id="product_id" class="form-select @error('product_id') is-invalid @enderror" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}" required>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="variant_price" class="form-label">Giá bán</label>
                            <input type="number" name="variant_price" id="variant_price" class="form-control @error('variant_price') is-invalid @enderror" value="{{ old('variant_price') }}" required>
                            @error('variant_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Tồn kho</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity') }}" required>
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Thuộc tính</label>
                            @foreach($attributes as $attribute)
                                <div class="mb-2">
                                    <strong>{{ $attribute->name }}</strong>
                                    <div>
                                        @foreach($attribute->attributeValues as $value)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="attribute_value_ids[]" value="{{ $value->id }}" {{ in_array($value->id, old('attribute_value_ids', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $value->value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            @error('attribute_value_ids')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="mdi mdi-content-save"></i> Lưu Biến Thể
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
