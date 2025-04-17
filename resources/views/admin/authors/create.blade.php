@extends('admin.layouts.app')
@section('title', 'Thêm Tác Giả')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Thêm Tác Giả Mới</h5>
                <a href="{{ route('authors.index') }}" class="btn btn-secondary">Quay Lại</a>
            </div>
            <div class="card-body">
                {{-- Hiển thị lỗi --}}
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

                <form action="{{ route('authors.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Tác Giả</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Tiểu Sử</label>
                        <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
