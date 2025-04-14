<!-- @extends('admin.layouts.app')
@section('title', 'Thêm Banner')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thêm Banner Mới</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link (tuỳ chọn)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thứ tự hiển thị</label>
                        <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)" required>
                        <img id="imagePreview" src="#" class="mt-2 d-none" width="200">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Lưu</button>
                        <a href="{{ route('banners.index') }}" class="btn btn-secondary">Huỷ</a>
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
