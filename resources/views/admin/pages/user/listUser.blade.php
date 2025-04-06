<?php
?>

@extends('admin.layouts.app')
@section('title', 'List Users')

@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Danh Sách Khách Hàng</h4>
            </div><!-- end card header -->
<div class="card-body">
    <div class="listjs-table">
        <div class="row g-4 mb-3">
            <div class="col-sm-auto">
                <div>
                    <a href="{{ route('admin.userCreate') }}" class="btn btn-success add-btn" id="create-btn" ><i class="ri-add-line align-bottom me-1"></i> Thêm</a>
                </div>
            </div>
            <div class="col-sm">
                <div class="d-flex justify-content-sm-end">
                    <div class="search-box ms-2">
                        <input type="text" class="form-control search" id="search-input" placeholder="Search...">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive table-card mt-3 mb-1">
            <table id="customerList" class="table align-middle table-nowrap table">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Avatar</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="id">{{ $user->id }}</td>
                        <td class="customer_name">{{ $user->name }}</td>
                        <td class="email">{{ $user->email }}</td>
                        <td class="avatar">{{ $user->avatar }}</td>
                        <td class="gender">{{ $user->gender }}</td>
                        <td class="birthdate">{{ $user->birthdate }}</td>
                        <td class="phone">{{ $user->phone }}</td>
                        <td class="address">{{ $user->address }}</td>
                        <td class="role"> 
                            @foreach($user->roles as $role)
                            {{ $role->name }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                        <td>
                            <div class="d-flex gap-2">
                                <div class="edit">
                                    <a href="{{ route('admin.userEdit', $user->id) }}" class="btn btn-sm btn-success edit-item-btn" >Sửa</a>
                                </div>
                                <div class="remove">
                                    <form action="{{ route('admin.destroyUser', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger remove-item-btn" 
                                        type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</button>
                                    </form>
                                </div>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="noresult" style="display: none">
                <div class="text-center">
                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                    <h5 class="mt-2">Sorry! No Result Found</h5>
                    <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any orders for your search.</p>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <div class="pagination-wrap hstack gap-2" style="display: flex;">
                <a class="page-item pagination-prev disabled" href="javascript:void(0);">Previous</a>
                <ul class="pagination listjs-pagination mb-0">
                    <li class="active"><a class="page" href="#" data-i="1" data-page="8">1</a></li>
                    <li><a class="page" href="#" data-i="2" data-page="8">2</a></li>
                </ul>
                <a class="page-item pagination-next" href="javascript:void(0);">Next</a>
            </div>
        </div>
    </div>
</div>


                                </div><!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                  

@endsection