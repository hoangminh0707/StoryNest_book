<?php
use Illuminate\Support\Facades\Route;

// ========== ADMIN CONTROLLERS ==========
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LoginAdminController;
use App\Http\Controllers\admin\RegisterAdminController;
use App\Http\Controllers\admin\UserAdminController;
use App\Http\Controllers\admin\RolesAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\PublisherAdminController;
use App\Http\Controllers\Admin\AttributeAdminController;
use App\Http\Controllers\Admin\AttributeValueAdminController;
use App\Http\Controllers\Admin\AuthorAdminController;
use App\Http\Controllers\Admin\CommentAdminController;
use App\Http\Controllers\Admin\ShippingMethodAdminController;
use App\Http\Controllers\Admin\VoucherAdminController;
use App\Http\Controllers\Admin\BannerAdminController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;
use App\Http\Controllers\Admin\PaymentAdminController;
use App\Http\Controllers\Admin\PaymentMethodAdminController;
use App\Http\Controllers\Admin\NotificationAdminController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\FlashDealController;



// ========== CLIENT CONTROLLERS ==========
use App\Http\Controllers\Client\ProductClientController;
use App\Http\Controllers\Client\AuthClientController;
use App\Http\Controllers\Client\WishlistClientController;
use App\Http\Controllers\Client\CartClientController;
use App\Http\Controllers\Client\UserAddressClientController;
use App\Http\Controllers\Client\CheckoutClientController;
use App\Http\Controllers\Client\OrderClientController;
use App\Http\Controllers\Client\VerificationClientController;
use App\Http\Controllers\Client\ProfileClientController;
use App\Http\Controllers\Client\BlogClientController;
use App\Http\Controllers\Client\CommentClientController;
use App\Http\Controllers\Client\ReviewCLientController;
use App\Http\Controllers\Client\VnpayController;
use App\Http\Controllers\Client\MomoController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\FlashSaleController;


require base_path('routes/channels.php');




//
// ─── CLIENT ROUTES ────────────────────────────────────────────────────────────────
//

Route::get('/', [ProductClientController::class, 'index'])->name('index');
Route::get('/shop', [ProductClientController::class, 'shop'])->name('shop');

Route::get('/login', [AuthClientController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthClientController::class, 'login']);
Route::get('/register', [AuthClientController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthClientController::class, 'register']);
Route::post('/logout', [AuthClientController::class, 'logout'])->name('logout');

Route::get('password/reset', [AuthClientController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [AuthClientController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthClientController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthClientController::class, 'reset'])->name('password.update');

Route::get('/about', [ProductClientController::class, 'about'])->name('about');// Blog - Client
Route::get('/blog', [BlogClientController::class, 'index'])->name('blogs.index');
Route::get('/blog/{id}', [BlogClientController::class, 'show'])->name('blogs.show');
// Blog - Client
Route::get('/blog', [BlogClientController::class, 'index'])->name('blogs.index');
Route::get('/blog/{id}', [BlogClientController::class, 'show'])->name('blogs.show');

Route::get('/contact', function () {
    return view('client.pages.contact');
})->name('contact');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');





// Xác thực Email, Hồ sơ, Địa chỉ người dùng
Route::middleware(['auth'])->group(function () {
    // Email verification
    Route::get('/email/verify', [VerificationClientController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [VerificationClientController::class, 'verify'])->name('verification.verify');
    Route::post('/email/resend', [VerificationClientController::class, 'resend'])->name('verification.resend');

    // Hồ sơ cá nhân
    Route::get('/profile', [ProfileClientController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileClientController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-email', [ProfileClientController::class, 'showChangeEmailForm'])->name('profile.email.change.form');
    Route::post('/profile/change-email', [ProfileClientController::class, 'changeEmail'])->name('profile.email.change');
    Route::get('/profile/change-password', [ProfileClientController::class, 'showChangePasswordForm'])->name('profile.password.form');
    Route::post('/profile/change-password', [ProfileClientController::class, 'changePassword'])->name('profile.password.update');

    // Địa chỉ người dùng
    Route::get('/addresses', [UserAddressClientController::class, 'index'])->name('addresses.index');
    Route::post('/addresses', [UserAddressClientController::class, 'store'])->name('addresses.store');
    Route::post('/addresses/set-default/{id}', [UserAddressClientController::class, 'setDefault'])->name('addresses.setDefault');
    Route::get('/addresses/{id}/edit', [UserAddressClientController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [UserAddressClientController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [UserAddressClientController::class, 'destroy'])->name('addresses.destroy');


    // Sản phẩm (chi tiết)
    Route::get('/product/{slug}', [ProductClientController::class, 'show'])->name('product.show');


    // Bình luận cho bài viết
    Route::post('/blogs/{blog}/comments', [CommentClientController::class, 'store'])->name('comments.store');
    Route::get('/blog/{id}', [BlogClientController::class, 'show'])->name('client.blog.show');

    Route::post('/comments', [CommentClientController::class, 'store'])->name('comments.store');


    //Giỏ hàng
    Route::get('/cart', [CartClientController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartClientController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartClientController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{product}', [CartClientController::class, 'remove'])->name('cart.remove');

    Route::get('/notifications/fetch', [NotificationAdminController::class, 'fetchUserNotifications'])->name('user.notifications.fetch');
});

// Người dùng phải đăng nhập và xác thực email để sử dụng
Route::middleware(['auth', 'verified'])->group(function () {

    // Wishlist
    Route::get('/wishlist', [WishlistClientController::class, 'index'])->name('wishlist.index');
    Route::get('/wishlist/add/{productId}', [WishlistClientController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/{productId}', [WishlistClientController::class, 'remove'])->name('wishlist.remove');


    // Checkout & Orders
    Route::get('/checkout', [CheckoutClientController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutClientController::class, 'submit'])->name('checkout.submit');
    Route::post('/checkout/update-address', [CheckoutClientController::class, 'updateAddress'])->name('checkout.updateAddress');
    Route::post('/checkout/update-shipping', [CheckoutClientController::class, 'updateShipping'])->name('checkout.updateShipping');
    Route::post('/checkout/update-payment', [CheckoutClientController::class, 'updatePayment'])->name('checkout.updatePayment');
    Route::post('/checkout/update-voucher', [CheckoutClientController::class, 'updateVoucher'])->name('checkout.updateVoucher');

    // Thanh toán online
    Route::get('/vnpay/payment', [VnpayController::class, 'createPaymentUrl'])->name('vnpay.payment');
    Route::get('/vnpay/callback', [VnpayController::class, 'handleCallback'])->name('vnpay.callback');

    Route::get('/momo/payment', [MomoController::class, 'createPayment'])->name('momo.payment');
    Route::get('/momo/return', [MomoController::class, 'handleReturn'])->name(name: 'momo.callback');
    Route::post('/momo/callback', [MomoController::class, 'handleCallback']);

    Route::get('/flash-sale', [FlashSaleController::class, 'index'])->name('client.flash-sale.index');


    Route::get('/orders/success', [OrderClientController::class, 'success'])->name('orders.success');
    Route::view('/orders/failed', 'client.pages.orders.failed')->name('orders.failed');
    Route::get('/orders', [OrderClientController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderClientController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/cancel', [OrderClientController::class, 'cancel'])->name('orders.cancel');


    Route::post('/reviews', [ReviewCLientController::class, 'store'])->name('reviews.store');

});



//
// ─── ADMIN ROUTES ──────────────────────────────────────────────────────────────────
//

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Đăng nhập / Đăng ký / Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/login', [LoginAdminController::class, 'showLoginAdminForm'])->name('login');
    Route::post('/login', [LoginAdminController::class, 'login']);
    Route::post('/logout', [LoginAdminController::class, 'logout'])->name('logout');
    Route::get('/register', [RegisterAdminController::class, 'showAdminRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterAdminController::class, 'registerAdmin'])->name('register');
   

    // Quản lý người dùng
    Route::get('/users', [UserAdminController::class, 'index'])->name('userIndex');
    Route::get('/users/create', [UserAdminController::class, 'create'])->name('userCreate');
    Route::post('/users/add', [UserAdminController::class, 'add'])->name('userAdd');
    Route::get('/users/{user}/edit', [UserAdminController::class, 'edit'])->name('userEdit');
    Route::put('/users/{user}', [UserAdminController::class, 'update'])->name('userUpdate');
    Route::delete('/users/{id}', [UserAdminController::class, 'destroy'])->name('userDelete');

    // Phân quyền
    Route::get('/roles', [RolesAdminController::class, 'index'])->name('roleIndex');
    Route::get('/roles/create', [RolesAdminController::class, 'create'])->name('roleCreate');
    Route::post('/roles', [RolesAdminController::class, 'add'])->name('addRole');
    Route::get('/roles/{role}/edit', [RolesAdminController::class, 'edit'])->name('roleEdit');
    Route::put('/roles/{role}', [RolesAdminController::class, 'update'])->name('updateRole');
    Route::delete('/roles/{role}', [RolesAdminController::class, 'destroy'])->name('destroyRole');

    // Danh mục sản phẩm
    Route::resource('categories', CategoryAdminController::class);

    // Sản phẩm
    Route::resource('products', ProductAdminController::class);
    Route::get('/products/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
    Route::delete('/products/images/{id}', [ProductAdminController::class, 'destroyImage'])->name('products.images.destroy');
    Route::post('/products/bulk-delete', [ProductAdminController::class, 'bulkDelete'])->name('products.bulkDelete');
    Route::post('/products/bulk-update-status', [ProductAdminController::class, 'bulkUpdateStatus'])->name('products.bulkUpdateStatus');


    // Tác giả - Nhà xuất bản
    Route::resource('publishers', PublisherAdminController::class);
    Route::resource('authors', AuthorAdminController::class);

    // Thuộc tính
    Route::resource('attributes', AttributeAdminController::class);
    Route::resource('attribute-values', AttributeValueAdminController::class);


    // Bình luận 
    Route::resource('comments', CommentAdminController::class)->except(['create', 'store']);

    // Duyệt và hủy duyệt bình luận
    Route::get('comments/{id}/approve', [CommentAdminController::class, 'approve'])->name('comments.approve');
    Route::get('comments/{id}/disapprove', [CommentAdminController::class, 'disapprove'])->name('comments.disapprove');

    // Trả lời bình luận
    Route::post('comments/{commentId}/reply', [CommentAdminController::class, 'reply'])->name('comments.reply');


    // đánh giá
    Route::resource('reviews', ReviewAdminController::class)->only(['index', 'show', 'destroy']);
    Route::patch('reviews/{id}/approve', [ReviewAdminController::class, 'approve'])->name('reviews.approve');

    // Đơn hàng
    Route::resource('orders', OrderAdminController::class)->only(['index', 'show', 'destroy']);
    Route::get('orders/{order}/edit-status', [OrderAdminController::class, 'editStatus'])->name('orders.editStatus');
    Route::put('orders/{order}/update-status', [OrderAdminController::class, 'updateStatus'])->name('orders.updateStatus');

    // Thanh toán
    Route::resource('payments', PaymentAdminController::class)->only(['index', 'show', 'destroy']);
    Route::post('payments/{id}/update-status', [PaymentAdminController::class, 'updateStatus'])->name('payments.updateStatus');
    Route::patch('payment-methods/{id}/toggle', [PaymentMethodAdminController::class, 'toggle'])->name('payment-methods.toggle');
    // Vận chuyển
    Route::resource('shipping-methods', ShippingMethodAdminController::class);
    Route::post('shipping-methods/{id}/toggle-status', [ShippingMethodAdminController::class, 'toggleStatus'])->name('shipping-methods.toggle-status');

    // Mã giảm giá
    Route::resource('vouchers', VoucherAdminController::class);
    Route::patch('vouchers/{id}/toggle-status', [VoucherAdminController::class, 'toggleStatus'])->name('vouchers.toggle-status');
    Route::patch('vouchers/{voucher}', [VoucherAdminController::class, 'update'])->name('vouchers.update');

    // Banner
    Route::resource('banners', BannerAdminController::class);
    Route::delete('banners/bulk-delete', [BannerAdminController::class, 'bulkDelete'])->name('banners.bulk-delete');
    Route::patch('banners/{id}/toggle', [BannerAdminController::class, 'toggleStatus'])->name('banners.toggle');

    // Blog
    Route::post('blogs/upload', [BlogAdminController::class, 'upload'])->name('blogs.upload');
    Route::post('/admin/blogs/upload-image', [BlogAdminController::class, 'uploadImage'])->name('admin.blogs.uploadImage');
    Route::resource('blogs', BlogAdminController::class);
    Route::post('blogs/mass-delete', [BlogAdminController::class, 'massDelete'])->name('blogs.massDelete');

    //Payment_method
    Route::resource('payment-methods', PaymentMethodAdminController::class);
    Route::post('payment-methods/{paymentMethod}/toggle-status', [PaymentMethodAdminController::class, 'toggleStatus'])->name('payment-methods.toggle-status');

    //Tồn kho 
    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('stocks/update', [StockController::class, 'updateStock'])->name('stocks.update');
    Route::get('stocks/history/{productId}', [StockController::class, 'showHistory'])->name('stocks.history');

    // flash_deals 
    Route::resource('flash_deals', FlashDealController::class);

    // AJAX route lấy biến thể sản phẩm
    Route::post('flash_deals/get_variants', [FlashDealController::class, 'getVariants'])->name('flash_deals.getVariants');

    // thông báo admin
    Route::get('/admin/notifications/fetch', [NotificationAdminController::class, 'fetch'])->name('notifications.fetch');

});