<?php
?>

@extends('admin.layouts.app')
@section('title', 'Edit Users')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Thêm Khách Hàng</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.updateUser', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="form-label" for="name" >Họ và tên</label>
                        <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user->name)}}" required >
                        @error('name')<div>{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="form-label" for="email" >Email</label>
                        <input class="form-control" type="text" id="email" name="email" value="{{ old('name', $user->email)}}" required >
                        @error('email')<div>{{ $message }}</div>@enderror
                    </div>
                
                
                    <div>
                        <label class="form-label" for="password">Mật khẩu</label>
                        <input class="form-control" type="password" id="password" name="password">
                        @error('password')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="gender">Giới tính</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                            <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="birthdate">Ngày sinh</label>
                        <input class="form-control" type="date" id="birthdate" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" required>
                        @error('birthdate')<div>{{ $message }}</div>@enderror
                    </div>
                
                    <div>
                        <label class="form-label" for="phone">Số điện thoại</label>
                        <input class="form-control" type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    </div>
                
                    <div>
                        <label class="form-label" for="address">Địa chỉ</label>
                        <input class="form-control" id="address" name="address" value="{{ old('address', $user->address) }}">
                    </div>

                    <label for="roles" class="form-label">Vai trò:</label>
                    <select class="form-select" id="roles" name="roles[]" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                
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