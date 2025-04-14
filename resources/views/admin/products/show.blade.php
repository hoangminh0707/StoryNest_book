@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết sản phẩm: {{ $product->name }}</h1>

    <div class="row">
        <div class="col-md-4">
            <strong>Ảnh đại diện:</strong><br>
            @if ($product->thumbnail)
                <img src="{{ asset('storage/' . $product->thumbnail->image_path) }}" alt="Thumbnail" width="200">
            @else
                <em>Không có ảnh</em>
            @endif
        </div>

        <div class="col-md-8">
            <p><strong>Mô tả:</strong> {{ $product->description }}</p>
            <p><strong>Tác giả:</strong> {{ $product->author->name ?? 'Không có' }}</p>
            <p><strong>Nhà xuất bản:</strong> {{ $product->publisher->name ?? 'Không có' }}</p>
            <p><strong>Danh mục:</strong> {{ $product->category->name ?? 'Không có' }}</p>
            <p><strong>Loại sản phẩm:</strong> {{ $product->product_type }}</p>
            <p><strong>Trạng thái:</strong> {{ $product->status }}</p>
            <p><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y') }}</p>
        </div>
    </div>

    <hr>

    @if($product->product_type === 'simple')
        <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} đ</p>
    @else
        <h4>Biến thể:</h4>
        @foreach ($product->variants as $variant)
            <div class="mb-3 p-3 border rounded">
                <p>
                    <strong>{{ $variant->variant_name }}</strong><br>
                    SKU: {{ $variant->sku }}<br>
                    Giá: {{ number_format($variant->variant_price, 0, ',', '.') }} đ<br>
                    Số lượng: {{ $variant->stock_quantity }}
                </p>
                @if ($variant->attributeValues->count())
                    <ul class="text-muted small">
                        @foreach ($variant->attributeValues as $value)
                            <li>{{ $value->attribute->name }}: {{ $value->value }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endforeach
    @endif

    <hr>

    <h4>Ảnh khác:</h4>
    @foreach ($product->images as $image)
        @if (!$image->is_thumbnail)
            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image" width="100" class="me-2 mb-2">
        @endif
    @endforeach
</div>
@endsection
