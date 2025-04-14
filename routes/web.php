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
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\VoucherConditionController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;




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
})->name('home');

Route::get('/shop', function () {
    return view('client.pages.shop');
})->name('shop');

Route::get('/about', function () {
    return view('client.pages.about');
})->name('about');

Route::get('/blog', function () {
    return view('client.pages.blog');
})->name('blog');

Route::get('/cart', function () {
    return view('client.pages.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('client.pages.checkout');
})->name('checkout');

Route::get('/contact', function () {
    return view('client.pages.contact');
})->name('contact');

Route::get('/post', function () {
    return view('client.pages.post');
})->name('post');

Route::get('/product', function () {
    return view('client.pages.product');
})->name('product');



Route::get('/admin', [AdminController::class, 'dashboard'])->middleware(['auth', 'role:admin'])->name('admin.dashboard');

Route::get('/admin/login', [LoginController::class, 'showLoginAdminForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');


Route::get('/admin/register', [RegisterController::class, 'showAdminRegistrationForm'])->name('register.admin.form');

Route::post('/admin/register', [RegisterController::class, 'registerAdmin'])->name('register.admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('userIndex'); // Danh sách người dùng
    Route::get('/users/create', [UserController::class, 'create'])->name('userCreate'); // Hiển thị form tạo người dùng
    Route::post('/users/add', [UserController::class, 'add'])->name('userAdd');         // Lưu người dùng mới
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('userEdit'); // Form sửa người dùng
    Route::put('/users/{user}', [UserController::class, 'update'])->name('userUpdate'); // Cập nhật người dùng
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('userDelete'); // Xóa người dùng
});


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
// Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// // Route để xử lý cập nhật sản phẩm
// Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
// Route để xóa ảnh của sản phẩm
// Route::delete('products/image/{image}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
// Route::delete('products/{id}/image', [ProductController::class, 'deleteImage'])->name('products.image.delete');


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

//Bình luận
Route::resource('comments', App\Http\Controllers\Admin\CommentController::class)->only(['index', 'destroy']);
Route::patch('comments/{id}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');



//Đánh giá
Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'show', 'destroy']);
Route::get('reviews/{id}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');

//Payment

Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class)->only([
    'index',
    'show',
    'destroy'
]);

Route::post('payments/{id}/update-status', [\App\Http\Controllers\Admin\PaymentController::class, 'updateStatus'])
    ->name('payments.updateStatus');

//Hình thức vận chuyển 
Route::resource('shipping-methods', ShippingMethodController::class);
Route::patch('/shipping-methods/{id}/toggle', [ShippingMethodController::class, 'toggleStatus'])->name('shipping-methods.toggle');


//Voucher 
Route::resource('vouchers', App\Http\Controllers\Admin\VoucherController::class);
Route::patch('vouchers/{voucher}/toggle', [App\Http\Controllers\Admin\VoucherController::class, 'toggle'])->name('vouchers.toggle');


// Route quản lý điều kiện áp dụng (VoucherCondition)
Route::resource('/admin/voucher-conditions', App\Http\Controllers\Admin\VoucherConditionController::class);


Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only([
    'index',
    'show',
    'destroy'
]);
Route::get('orders/{order}/edit-status', [\App\Http\Controllers\Admin\OrderController::class, 'editStatus'])->name('orders.editStatus');
Route::put('orders/{order}/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');


Route::resource('admin/banners', BannerController::class); // Tạo các route cho các phương thức resource
Route::delete('banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');  // Route cho bulk delete
Route::patch('banners/{id}/toggle', [BannerController::class, 'toggleStatus'])->name('banners.toggle');

Route::prefix('admin')->group(function () {
    Route::resource('blogs', BlogController::class);
    Route::post('blogs/mass-delete', [BlogController::class, 'massDelete'])->name('admin.blogs.massDelete');
});