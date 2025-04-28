@extends('admin.layouts.app')

@section('title', 'Sửa Bài Viết')

@section('content')
<div class="container-xxl py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

         

            <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tiêu Đề --}}
                <div class="mb-4">
                    <label for="title" class="form-label">
                        Tiêu Đề <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control form-control-lg @error('title') is-invalid @enderror"
                        value="{{ old('title', $blog->title) }}"
                        placeholder="Nhập tiêu đề…"
                        
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nội Dung --}}
                <div class="mb-4">
                    <label for="content" class="form-label">
                        Nội Dung <span class="text-danger">*</span>
                    </label>
                    <textarea
                        id="content"
                        name="content"
                        class="form-control @error('content') is-invalid @enderror"
                        rows="8"
                        placeholder="Viết nội dung…"
                        
                    >{{ old('content', $blog->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Ảnh Đại Diện --}}
                <div class="row gx-3 mb-4">
                    <div class="col-md-6">
                        <label for="image_url" class="form-label">
                            Ảnh Đại Diện
                        </label>
                        <input
                            type="file"
                            id="image_url"
                            name="image_url"
                            class="form-control @error('image_url') is-invalid @enderror"
                            accept="image/*"
                            onchange="previewImage(event)"
                        >
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="w-100 text-center">
                            <label class="form-label d-block">Preview Ảnh</label>
                            @if($blog->image_url)
                                <img
                                    id="image-preview"
                                    src="{{ asset('storage/' . $blog->image_url) }}"
                                    class="img-thumbnail"
                                    style="max-height:200px; object-fit:cover;"
                                >
                            @else
                                <img
                                    id="image-preview"
                                    src="#"
                                    class="img-thumbnail"
                                    style="max-height:200px; object-fit:cover; display:none;"
                                >
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Trạng Thái --}}
                <div class="mb-4">
                    <label class="form-label">
                        Trạng Thái <span class="text-danger">*</span>
                    </label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="status_draft"
                                name="status"
                                value="draft"
                                {{ old('status', $blog->status)=='draft' ? 'checked':'' }}
                                
                            >
                            <label class="form-check-label" for="status_draft">Nháp</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                class="form-check-input"
                                type="radio"
                                id="status_published"
                                name="status"
                                value="published"
                                {{ old('status', $blog->status)=='published' ? 'checked':'' }}
                                
                            >
                            <label class="form-check-label" for="status_published">xuất bản</label>
                        </div>
                    </div>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Quay Lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', 'mediaEmbed',
                'imageUpload', '|', 'undo', 'redo'
            ],
            ckfinder: {
                uploadUrl: '{{ route('admin.blogs.upload') }}?_token={{ csrf_token() }}'
            },
            image: {
                resizeUnit: 'px',
                resizeOptions: [
                    { name: 'resizeImage:original', label: 'Original', value: null },
                    { name: 'resizeImage:50', label: '50%', value: '50' },
                    { name: 'resizeImage:75', label: '75%', value: '75' },
                    { name: 'resizeImage:100', label: '100%', value: '100' }
                ]
            }
        })
        .catch(error => console.error(error));

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.getElementById('image-preview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
