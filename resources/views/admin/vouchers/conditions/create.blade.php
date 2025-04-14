@extends('admin.layouts.app')
@section('title', 'Thêm Điều Kiện')

@section('content')
    <div class="card">
        <div class="card-header"><h5>Thêm Điều Kiện Cho: {{ $voucher->name }}</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.voucher-conditions.store', $voucher->id) }}">
                @csrf

                <div class="mb-3">
                    <label>Loại Điều Kiện:</label>
                    <select name="condition_type" class="form-control" required>
                        <option value="product">Sản phẩm</option>
                        <option value="category">Danh mục</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Sản phẩm (tuỳ chọn):</label>
                    <select name="product_id" class="form-control">
                        <option value="">-- Chọn --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Danh mục (tuỳ chọn):</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- Chọn --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Thêm Điều Kiện</button>
                <a href="{{ route('admin.voucher-conditions.index', $voucher->id) }}" class="btn btn-secondary">Huỷ</a>
            </form>
        </div>
    </div>
@endsection
