@extends('admin.layouts.app')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="container-fluid py-4">
                {{-- Header with title and actions --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold text-primary">{{ $product->name }}</h2>
                    <div>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary me-3">
                            <i class="ri-arrow-left-line align-middle me-1"></i> Quay lại
                        </a>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary me-2">
                            <i class="ri-edit-2-line align-middle"></i> Sửa
                        </a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger">
                                <i class="ri-delete-bin-5-line align-middle"></i> Xóa
                            </button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    {{-- Left: Image Carousel and Meta --}}
                    <div class="col-lg-5 mb-4">
                          <div id="productCarousel" class="carousel slide rounded shadow-sm" data-bs-ride="carousel" style="max-width:300px;margin:auto;">
        <div class="carousel-inner" style="height:300px;">
          @foreach($product->images as $img)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
              <img src="{{ Storage::url($img->image_path) }}" class="d-block mx-auto" alt="{{ $product->name }}" style="max-height:300px; object-fit:contain;" />
            </div>
          @endforeach
        </div>
        @if(count($product->images) > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
        @endif
      </div>

                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item"><strong>Trạng thái:</strong>
                                @if($product->status == 'published')
                                <span class="badge bg-success">Đã đăng</span>
                                @else
                                <span class="badge bg-secondary">Nháp</span>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <strong>Loại:</strong>
                                @if($product->product_type === 'simple')
                                Sản phẩm đơn
                                @elseif($product->product_type === 'variable')
                                Sản phẩm biến thể
                                @else
                                {{ ucfirst($product->product_type) }}
                                @endif
                            </li>

                            <li class="list-group-item"><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y') }}</li>
                        </ul>
                    </div>

                    {{-- Right: Details and Variants --}}
                    <div class="col-lg-7">
                        <div class="mb-4">
                            <h5 class="mb-2">Mô tả</h5>
                            <p class="text-muted">{{ $product->description }}</p>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6>Tác giả</h6>
                                <p>{{ $product->author->name ?? 'Không có' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <h6>Nhà xuất bản</h6>
                                <p>{{ $product->publisher->name ?? 'Không có' }}</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6>Danh mục</h6>
                            <div>
                                @foreach($product->categories as $cat)
                                <span class="badge bg-primary me-1">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-4">
                            <h5 class="text-primary">Giá bán</h5>
                            @if($product->product_type == 'simple')
                            <p class="fs-3 text-success">{{ number_format($product->price,0,',','.') }} đ</p>
                            <h5 class="text-primary">Số lượng</h5>
                            <p class="fs-3 text-success">Còn  {{ $product->quantity }} sản phẩm </p>
                            @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Biến thể</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->variants as $variant)
                                    <tr>
                                        <td>
                                            @foreach($variant->attributeValues as $av)
                                            <span class="badge bg-light text-dark me-1">{{ $av->attribute->name }}: {{ $av->value }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ number_format($variant->variant_price,0,',','.') }} đ</td>
                                        <td>{{ $variant->stock_quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection