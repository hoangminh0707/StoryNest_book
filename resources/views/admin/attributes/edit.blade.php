@extends('admin.layouts.app')
@section('title', 'Sửa Thuộc Tính')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sửa Thuộc Tính</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attributes.update', $attribute->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Thuộc Tính</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name', $attribute->name) }}" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Cập Nhật Thuộc Tính</button>
                        <a href="{{ route('attributes.index') }}" class="btn btn-secondary ms-2">Quay Lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
