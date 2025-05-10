<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('client.pages.index');
});

Route::get('/shop', function () {
    return view('client.pages.shop');
});

Route::get('/about', function () {
    return view('client.pages.about');
});


Route::get('/blog', function () {
    return view('client.pages.blog');
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




Route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::get('/admin/login', [LoginController::class, 'showLoginAdminForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');


Route::get('/admin/register', [RegisterController::class, 
'showAdminRegistrationForm'])->name('register.admin.form');

Route::post('/admin/register', [RegisterController::class, 
'registerAdmin'])->name('register.admin');

Route::get('/admin-User', [UserController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.userIndex');

Route::get('/admin-addUser', [UserController::class, 'create'])->name('admin.userCreate');
Route::post('/admin-addUser', [UserController::class, 'add'])->name('admin.addUser');

Route::get('/admin-editUser/{user}', [UserController::class, 'edit'])->name('admin.userEdit');
Route::put('/admin-editUser/{user}', [UserController::class, 'update'])->name('admin.updateUser');

Route::delete('/admin-destroyUser/{user}', [UserController::class, 'destroy'])->name('admin.destroyUser');


Route::get('/admin-Roles', [RolesController::class, 'index'])->middleware(['auth', 'role:admin'])->name('admin.roleIndex');

Route::get('/admin-addRole', [RolesController::class, 'create'])->name('admin.roleCreate');
Route::post('/admin-addRole', [RolesController::class, 'add'])->name('admin.addRole');

Route::get('/admin-editRole/{role}', [RolesController::class, 'edit'])->name('admin.roleEdit');
Route::put('/admin-editRole/{role}', [RolesController::class, 'update'])->name('admin.updateRole');

Route::delete('/admin-destroyRole/{role}', [RolesController::class, 'destroy'])->name('admin.destroyRole');


// 📌 Quản lý Danh mục sản phẩm (Categories)
Route::resource('admin/categories', CategoryController::class);

// 📌 Quản lý Sản phẩm (Products)
Route::resource('admin/products', ProductController::class);
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
// Route để hiển thị form sửa sản phẩm
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Route để xử lý cập nhật sản phẩm
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route để xóa ảnh của sản phẩm
Route::delete('products/image/{image}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
Route::delete('products/{id}/image', [ProductController::class, 'deleteImage'])->name('products.image.delete');


// 📌 Quản lý Nhà xuất bản (Publishers)
Route::resource('admin/publishers', PublisherController::class);

// 📌 Quản lý Tác giả (Authors)
Route::resource('admin/authors', AuthorController::class);

// 📌 Quản lý Thuộc tính (Attributes)
Route::resource('attributes', AttributeController::class);
Route::resource('attribute_values', AttributeValueController::class);

// Các route cho biến thể sản phẩm
Route::resource('product_variants', ProductVariantController::class);

// Route cho danh sách ảnh sản phẩm
Route::resource('product-images', ProductImageController::class);






