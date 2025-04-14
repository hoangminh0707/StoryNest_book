<!-- @extends('admin.layouts.app')
@section('title', 'Sửa Banner')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Chỉnh sửa Banner</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $banner->link) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', $banner->order) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh mới (tuỳ chọn)</label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                        @if ($banner->image_url)
                            <img id="imagePreview" src="{{ asset('storage/' . $banner->image_url) }}" class="mt-2" width="200">
                        @else
                            <img id="imagePreview" class="mt-2 d-none" width="200">
                        @endif
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const image = document.getElementById('imagePreview');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.classList.remove('d-none');
    }
</script>
@endsection -->
