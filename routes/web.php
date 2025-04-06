<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


Route::get('/admin', function () {
    return view('admin.pages.dashboards');
})->name('admin.dashboard');
Route::get('/list-orders',[\App\Http\Controllers\admin\OrderController::class,'index'])->name('listOrders');
Route::get('order-detail/{order_id}',[\App\Http\Controllers\admin\OrderController::class,'show'])->name('orderDetail');
Route::post('order-update/{order_id}',[\App\Http\Controllers\admin\OrderController::class,'updateStatus'])->name('updateOrder');
Route::resource('comments', CommentController::class)->only(['index', 'destroy']);
Route::patch('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
Route::resource('blogs', BlogController::class); // Tạo các route CRUD cho bài viết
Route::resource('reviews', ReviewController::class)->except(['create', 'store', 'edit', 'update']);
Route::patch('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
Route::resource('banners', BannerController::class);

