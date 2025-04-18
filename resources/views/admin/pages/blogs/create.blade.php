@extends('admin.layouts.app')

@section('title', 'Thêm Bài Viết')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            {{-- Thông báo thành công --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Thông báo lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Card tạo bài viết --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm Bài Viết Mới</h5>
                </div>

                <div class="card-body">
                    {{-- Form tạo bài viết --}}
                    <form action="{{ route('admin.blogs.store') }}" method="POST">
                        @csrf

                        {{-- Tiêu đề --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu Đề</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                required>
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nội dung --}}
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội Dung</label>
                            <textarea name="content" id="content"
                                class="form-control @error('content') is-invalid @enderror" rows="5"
                                required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Trạng thái --}}
                        <div class="mb-3">
                            <label class="form-label">Trạng Thái</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_draft" value="draft"
                                    {{ old('status') == 'draft' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_draft">Nháp</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status_published"
                                    value="published" {{ old('status') == 'published' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_published">Đã Xuất Bản</label>
                            </div>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nút tạo bài viết --}}
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="mdi mdi-plus-circle"></i> Tạo Bài Viết
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection