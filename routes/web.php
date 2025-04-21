<?php
use Illuminate\Support\Facades\Route;

// ========== ADMIN CONTROLLERS ==========
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ShippingMethodController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PaymentMethodController;

// ========== CLIENT CONTROLLERS ==========
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ProfileController;

//
// ─── CLIENT ROUTES ────────────────────────────────────────────────────────────────
//

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Sản phẩm (chi tiết)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
});

// Xác thực Email, Hồ sơ, Địa chỉ người dùng
Route::middleware(['auth'])->group(function () {
    // Email verification
    Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-email', [ProfileController::class, 'showChangeEmailForm'])->name('profile.email.change.form');
    Route::post('/profile/change-email', [ProfileController::class, 'changeEmail'])->name('profile.email.change');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password.form');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.password.update');

    // Địa chỉ người dùng
    Route::get('/addresses', [UserAddressController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [UserAddressController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/set-default/{id}', [UserAddressController::class, 'setDefault'])->name('addresses.setDefault');
    Route::get('/addresses/{id}/edit', [UserAddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [UserAddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy'])->name('addresses.destroy');

    // Checkout & Orders
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'submit'])->name('checkout.submit');

    Route::get('/orders/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Wishlist
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::get('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});



//
// ─── ADMIN ROUTES ──────────────────────────────────────────────────────────────────
//

Route::prefix('admin')->name('admin.')->group(function () {
    // Đăng nhập / Đăng ký / Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->middleware(['auth', 'role:admin'])->name('dashboard');
    Route::get('/login', [LoginController::class, 'showLoginAdminForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterController::class, 'showAdminRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'registerAdmin'])->name('register');

    // Quản lý người dùng
    Route::get('/users', [UserController::class, 'index'])->name('userIndex');
    Route::get('/users/create', [UserController::class, 'create'])->name('userCreate');
    Route::post('/users/add', [UserController::class, 'add'])->name('userAdd');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('userEdit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('userUpdate');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('userDelete');

    // Phân quyền
    Route::get('/roles', [RolesController::class, 'index'])->name('roleIndex');
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roleCreate');
    Route::post('/roles', [RolesController::class, 'add'])->name('addRole');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roleEdit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('updateRole');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('destroyRole');

    // Danh mục sản phẩm
    Route::resource('categories', CategoryController::class);

    // Sản phẩm
    Route::resource('products', ProductAdminController::class);
    Route::get('/products/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
    Route::delete('/products/images/{id}', [ProductAdminController::class, 'destroyImage'])->name('products.images.destroy');

    // Tác giả - Nhà xuất bản
    Route::resource('publishers', PublisherController::class);
    Route::resource('authors', AuthorController::class);

    // Thuộc tính
    Route::resource('attributes', AttributeController::class);
    Route::resource('attribute-values', AttributeValueController::class);


    // Bình luận & đánh giá
    Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
    Route::patch('comments/{id}/approve', [CommentController::class, 'approve'])->name('comments.approve');


    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy']);
    Route::patch('reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');

    // Đơn hàng
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::get('orders/{order}/edit-status', [AdminOrderController::class, 'editStatus'])->name('orders.editStatus');
    Route::put('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Thanh toán
    Route::resource('payments', PaymentController::class)->only(['index', 'show', 'destroy']);
    Route::post('payments/{id}/update-status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
    Route::patch('payment-methods/{id}/toggle', [PaymentMethodController::class, 'toggle'])->name('payment-methods.toggle');
    // Vận chuyển
    Route::resource('shipping-methods', ShippingMethodController::class);
    Route::post('shipping-methods/{id}/toggle-status', [ShippingMethodController::class, 'toggleStatus'])->name('shipping-methods.toggle-status');

    // Mã giảm giá
    Route::resource('vouchers', VoucherController::class);
    Route::patch('vouchers/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('vouchers.toggle-status');
    Route::patch('vouchers/{voucher}', [VoucherController::class, 'update'])->name('vouchers.update');

    // Banner
    Route::resource('banners', BannerController::class);
    Route::delete('banners/bulk-delete', [BannerController::class, 'bulkDelete'])->name('banners.bulk-delete');
    Route::patch('banners/{id}/toggle', [BannerController::class, 'toggleStatus'])->name('banners.toggle');

    // Blog
    Route::resource('blogs', BlogController::class);
    Route::post('blogs/mass-delete', [BlogController::class, 'massDelete'])->name('blogs.massDelete');

    //Payment_method
    Route::resource('payment-methods', PaymentMethodController::class);
    Route::post('payment-methods/{paymentMethod}/toggle-status', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'toggleStatus'])->name('payment-methods.toggle-status');


});