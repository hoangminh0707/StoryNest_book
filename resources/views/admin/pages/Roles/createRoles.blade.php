<?php
?>

@extends('admin.layouts.app')
@section('title', 'Create Role')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Thêm Khách Hàng</h4>
            </div><!-- end card header -->
            <div class="card-body">
                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.addRole') }}">
                    @csrf

                    <div>
                        <label class="form-label" for="name" >Tên Vai Trò</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="description">Mô tả vai trò</label>
                        <input class="form-control" type="text" id="description" name="description" value="{{ old('description') }}" required>
                        @error('description')<div>{{ $message }}</div>@enderror
                    </div>
                
                    
                    <button type="submit" class="btn btn-success float-end m-3">Thêm</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection