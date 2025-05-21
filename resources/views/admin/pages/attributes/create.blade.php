@extends('admin.layouts.app')
@section('title', 'Thêm Thuộc Tính Mới')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm Thuộc Tính Mới</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attributes.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Thuộc Tính</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Lưu Thuộc Tính</button>
                            <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary ms-2">Quay Lại</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection