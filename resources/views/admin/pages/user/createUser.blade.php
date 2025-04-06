<?php
?>

@extends('admin.layouts.app')
@section('title', 'Create Users')
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

                <form method="POST" action="{{ route('admin.addUser') }}">
                    @csrf

                    <div>
                        <label class="form-label" for="name" >Họ và tên</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="password">Mật khẩu</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                        @error('password')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="gender">Giới tính</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="birthdate">Ngày sinh</label>
                        <input class="form-control" type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
                        @error('birthdate')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="phone">Số điện thoại</label>
                        <input class="form-control" type="text" id="phone" name="phone" value="{{ old('phone') }}">
                    </div>
                
                    <div>
                        <label class="form-label" for="address">Địa chỉ</label>
                        <input class="form-control" id="address" name="address" value="{{ old('address') }}">
                    </div>
                    
                    <button type="submit" class="btn btn-success float-end m-3">Thêm</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection