<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\RolesController;





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




