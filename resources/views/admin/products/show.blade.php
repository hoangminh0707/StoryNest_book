@extends('admin.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Chi Tiết Sản Phẩm</h4>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay Lại</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Thông tin sản phẩm -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $product->name }}</h4>
                            <p>{{ $product->description }}</p>
                            <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} đ</p>
                            <p><strong>Danh Mục:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                            <p><strong>Tác Giả:</strong> {{ $product->author->name ?? 'Chưa có' }}</p>
                            <p><strong>Nhà Xuất Bản:</strong> {{ $product->publisher->name ?? 'Chưa có' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ảnh sản phẩm -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Hình Ảnh</h5>
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="img-fluid mb-2">
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Biến thể sản phẩm -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Biến Thể</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Tên Biến Thể</th>
                                        <th>Giá</th>
                                        <th>Số Lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->variants as $variant)
                                        <tr>
                                            <td>{{ $variant->sku }}</td>
                                            <td>{{ $variant->variant_name }}</td>
                                            <td>{{ number_format($variant->variant_price, 0, ',', '.') }} đ</td>
                                            <td>{{ $variant->stock_quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
