@extends('admin.layouts.app')
@section('title', 'Chỉnh Sửa Vai Trò')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.roleIndex') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <h4 class="mb-0">Chỉnh Sửa Vai Trò</h4>
                </div>
            </div>
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Vui lòng kiểm tra lại:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.roleUpdate', $role->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Vai Trò</label>
                        <input type="text" name="name" id="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $role->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả Vai Trò</label>
                        <input type="text" name="description" id="description"
                               class="form-control @error('description') is-invalid @enderror"
                               value="{{ old('description', $role->description) }}" required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Cập Nhật
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
