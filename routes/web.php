<?php

use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;

// Trang chủ client
Route::get('/', function () {
    return view('client.pages.index');
});

// Các trang của client
Route::get('/shop', function () {
    return view('client.pages.shop');
});
Route::get('/about', function () {
    return view('client.pages.about');
});
Route::get('/cart', function () {
    return view('client.pages.cart');
});
Route::get('/checkout', function () {
    return view('client.pages.checkout');
});
Route::get('/contact', function () {
    return view('client.pages.contact');
});
Route::get('/post', function () {
    return view('client.pages.post');
});
Route::get('/product', function () {
    return view('client.pages.product');
});

// Blog - Client
Route::get('/blog', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blogs.show');

// Bình luận cho bài viết
Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');

// Admin Routes
Route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Admin Login
Route::get('/admin/login', [LoginController::class, 'showLoginAdminForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Admin Register
Route::get('/admin/register', [RegisterController::class, 'showAdminRegistrationForm'])->name('register.admin.form');
Route::post('/admin/register', [RegisterController::class, 'registerAdmin'])->name('register.admin');

// Admin User Management
Route::get('/admin/users', [UserController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.userIndex');
Route::get('/admin/addUser', [UserController::class, 'create'])->name('admin.userCreate');
Route::post('/admin/addUser', [UserController::class, 'add'])->name('admin.addUser');
Route::get('/admin/editUser/{user}', [UserController::class, 'edit'])->name('admin.userEdit');
Route::put('/admin/editUser/{user}', [UserController::class, 'update'])->name('admin.updateUser');
Route::delete('/admin/destroyUser/{user}', [UserController::class, 'destroy'])->name('admin.destroyUser');

// Admin Role Management
Route::get('/admin/roles', [RolesController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.roleIndex');
Route::get('/admin/addRole', [RolesController::class, 'create'])->name('admin.roleCreate');
Route::post('/admin/addRole', [RolesController::class, 'add'])->name('admin.addRole');
Route::get('/admin/editRole/{role}', [RolesController::class, 'edit'])->name('admin.roleEdit');
Route::put('/admin/editRole/{role}', [RolesController::class, 'update'])->name('admin.updateRole');
Route::delete('/admin/destroyRole/{role}', [RolesController::class, 'destroy'])->name('admin.destroyRole');

