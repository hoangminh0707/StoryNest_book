@extends('admin.layouts.app')

@section('title', 'Thêm Bài Viết')

@section('content')
<div class="container-xxl py-4">
    <div class="card shadow-sm">
    <div class="card-body">
        {{-- Thông báo thành công --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Form Thêm Bài Viết --}}
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="form-label" for="title">Tiêu Đề</label>
                <input type="text" name="title" id="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title') }}">
                @error('title')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="content">Nội dung</label>
                <textarea name="content" id="content" class="form-control" rows="10">{{ old('content') }}</textarea>
                @error('content')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label" for="image_url">Ảnh</label>
                <input type="file" name="image_url" id="image_url" class="form-control @error('image_url') is-invalid @enderror" onchange="previewImage(event)">
                @error('image_url')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Preview Ảnh</label>
                <div id="image-preview-container">
                    <img id="image-preview" src="" alt="Preview" class="img-fluid" style="max-height: 300px; object-fit: cover; display: none;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Trạng Thái</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_draft" value="draft"
                        {{ old('status') == 'draft' ? 'checked' : '' }}>
                    <label class="form-check-label" for="status_draft">Nháp</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="status_published"
                        value="published" {{ old('status') == 'published' ? 'checked' : '' }}>
                    <label class="form-check-label" for="status_published">Xuất Bản</label>
                </div>
                @error('status')
                <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success w-sm">Lưu</button>
                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary w-sm">Quay Lại</a>
            </div>

        </form>
    </div>
</div>
</div>

{{-- Script khởi tạo CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', 'imageUpload', 'insertTable', 'mediaEmbed'],
            image: {
                resizeUnit: 'px',
                resizeOptions: [{
                        name: 'resizeImage:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    },
                    {
                        name: 'resizeImage:100',
                        label: '100%',
                        value: '100'
                    }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });

    // Function preview image
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image-preview');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image preview
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection