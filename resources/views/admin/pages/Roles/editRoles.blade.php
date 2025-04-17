<<<<<<< HEAD
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

                {{-- Hiển thị lỗi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Lỗi:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Hiển thị input nếu cần --}}
                @if (session('input'))
                    <div class="alert alert-info">
                        <strong>Dữ liệu nhận được:</strong>
                        <ul class="mb-0">
                            @foreach (session('input') as $key => $value)
                                <li>{{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

=======
<?php
?>

@extends('admin.layouts.app')
@section('title', 'Edit Roles')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Thêm Khách Hàng</h4>
            </div><!-- end card header -->
            <div class="card-body">
>>>>>>> duong
                <form method="POST" action="{{ route('admin.updateRole', $role->id) }}">
                    @csrf
                    @method('PUT')

<<<<<<< HEAD
                    <div class="mb-3">
                        <label class="form-label" for="name">Tên Vai Trò</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            id="name" name="name" value="{{ old('name', $role->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="description">Mô Tả Vai Trò</label>
                        <input class="form-control @error('description') is-invalid @enderror" type="text"
                            id="description" name="description" value="{{ old('description', $role->description) }}" required>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Cập Nhật
                        </button>
                    </div>
=======
                    <div>
                        <label class="form-label" for="name" >Tên vai trò</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $role->name)}}" required >
                        @error('name')<div>{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label" for="description" >Mô tả vai trò</label>
                        <input class="form-control" type="text" id="description" name="description" value="{{ old('name', $role->description)}}" required >
                        @error('description')<div>{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-success float-end m-3">Cập Nhật</button>
>>>>>>> duong
                </form>

            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
@endsection
=======

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (session('input'))
<div>
    <h2>Received Input:</h2>
    <ul>
        @foreach (session('input') as $key => $value)
            <li>{{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}</li>
        @endforeach
    </ul>
</div>
@endif





@endsection
>>>>>>> duong
