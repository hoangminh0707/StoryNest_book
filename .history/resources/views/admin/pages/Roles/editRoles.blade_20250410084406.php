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
                <form method="POST" action="{{ route('admin.updateRole', $role->id) }}">
                    @csrf
                    @method('PUT')

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
                </form>

            </div>
        </div>
    </div>
</div>

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