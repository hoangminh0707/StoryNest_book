<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\Admin\ProductController2;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;










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


Route::middleware('auth')->group(function () {
    Route::get('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');


});


Route::middleware(['auth'])->group(function () {
    Route::get('/addresses', [UserAddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [UserAddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/set-default/{id}', [UserAddressController::class, 'setDefault'])->name('addresses.setDefault');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'submit'])->name('checkout.submit');


    Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

});








Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/', [ProductController::class, 'index'])->name('index');

Route::get('/shop', [ProductController::class, 'shop'])->name('shop');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');


Route::get('/about', function () {
    return view('client.pages.about');
});


Route::get('/blog', function () {
    return view('client.pages.blog')->name('blog');
});

Route::get('/contact', function () {
    return view('client.pages.contact')->name('contact');
});

Route::get('/post', function () {
    return view('client.pages.post')->name('post');
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
Route::resource('admin/products', ProductController2::class);
Route::get('/products/{id}', [ProductController2::class, 'show'])->name('products.show');
// Route để hiển thị form sửa sản phẩm
Route::get('products/{product}/edit', [ProductController2::class, 'edit'])->name('products.edit');
// Route để xử lý cập nhật sản phẩm
Route::put('products/{product}', [ProductController2::class, 'update'])->name('products.update');
// Route để xóa ảnh của sản phẩm
Route::delete('products/image/{image}', [ProductController2::class, 'deleteImage'])->name('products.image.delete');
Route::delete('products/{id}/image', [ProductController2::class, 'deleteImage'])->name('products.image.delete');


// 📌 Quản lý Nhà xuất bản (Publishers)
Route::resource('admin/publishers', PublisherController::class);





// Các route cho biến thể sản phẩm
Route::resource('product_variants', ProductVariantController::class);

// Route cho danh sách ảnh sản phẩm
Route::resource('product-images', ProductImageController::class);





