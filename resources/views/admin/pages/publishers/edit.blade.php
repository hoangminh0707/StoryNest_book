@extends('admin.layouts.app')
@section('title', 'Chỉnh sửa Nhà Xuất Bản')

@section('content')
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            {{-- Thông báo --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Chỉnh sửa Nhà Xuất Bản</h5>
                    <a href="{{ route('admin.publishers.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i> Quay lại
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.publishers.update', $publisher->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Nhà Xuất Bản</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $publisher->name) }}"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="nationality" class="form-label">Quốc Gia</label>
                            <input type="text" name="nationality" id="nationality"
                                value="{{ old('nationality', $publisher->nationality) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa Chỉ</label>
                            <textarea name="address" id="address" class="form-control"
                                rows="3">{{ old('address', $publisher->address) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Cập nhật
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection