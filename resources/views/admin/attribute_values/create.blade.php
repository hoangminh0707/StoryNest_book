@extends('admin.layouts.app')
@section('title', 'Thêm Giá Trị Thuộc Tính')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Thêm Giá Trị Thuộc Tính</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('attribute_values.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="attribute_id" class="form-label">Thuộc Tính</label>
                            <select name="attribute_id" id="attribute_id" class="form-select" required>
                                <option value="">-- Chọn Thuộc Tính --</option>
                                @foreach ($attributes as $attribute)
                                    <option value="{{ $attribute->id }}" {{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                        {{ $attribute->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('attribute_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Giá Trị</label>
                            <input type="text" name="value" id="value" class="form-control" value="{{ old('value') }}" required>
                            @error('value')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Lưu</button>
                        <a href="{{ route('attribute_values.index') }}" class="btn btn-secondary ms-2">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
