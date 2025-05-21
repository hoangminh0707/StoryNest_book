@extends('admin.layouts.app')
@section('content')
<div class="main-content">
    <div class="page-content">
      
            <h4 class="mb-sm-0">Chỉnh sửa Danh Mục</h4>

            <form action="{{ route('categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Tên danh mục</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea name="description" class="form-control">{{ $category->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="parent_id">Danh mục cha</label>
                    <select name="parent_id" class="form-control">
                        <option value="">Chọn danh mục cha</option>
                        @foreach($categories as $parent)
                            <option value="{{ $parent->id }}" {{ $category->parent_id == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
            </form>
        </div>
    </div>
</div>
@endsection
