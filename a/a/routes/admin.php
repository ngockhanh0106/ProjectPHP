<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UploadMultipleImage;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/login', [AuthController::class, 'formLogin'])->name('admin.get.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.post.login');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin'], 'as' => 'admin.'], function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('index')->middleware('permission:product_view');
        Route::post('/', [ProductController::class, 'store'])->name('store')->middleware('permission:product_store');
        Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware('permission:product_store');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit')->middleware('permission:product_update');
        Route::patch('/{id}', [ProductController::class, 'update'])->name('update')->middleware('permission:product_update');
        Route::delete('/{id}', [ProductController::class, 'delete'])->name('delete')->middleware('permission:product_delete');
    });

    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware('permission:category_view');
        Route::post('/', [CategoryController::class, 'store'])->name('store')->middleware('permission:category_store');
        Route::get('/create', [CategoryController::class, 'create'])->name('create')->middleware('permission:category_store');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit')->middleware('permission:category_update');
        Route::patch('/{id}', [CategoryController::class, 'update'])->name('update')->middleware('permission:category_update');
        Route::delete('/{id}', [CategoryController::class, 'delete'])->name('delete')->middleware('permission:category_delete');
    });

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{orderCode}', [OrderController::class, 'show'])->name('show');
        Route::post('/updateStatus', [OrderController::class, 'updateStatus'])->name('update.status');
    });

    Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function(){
        Route::get('/', [BlogController::class, 'index'])->name('index')->middleware('permission:blog_view');
        Route::post('/', [BlogController::class, 'store'])->name('store')->middleware('permission:blog_store');
        Route::get('/create', [BlogController::class, 'create'])->name('create')->middleware('permission:blog_store');
        Route::post('/upload-ckeditor', [BlogController::class, 'uploadCkeditor'])->name('upload.ckeditor');
        Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('edit')->middleware('permission:blog_update');
        Route::patch('/{id}', [BlogController::class, 'update'])->name('update')->middleware('permission:blog_update');
        Route::delete('/{id}', [BlogController::class, 'delete'])->name('delete')->middleware('permission:blog_delete');
    });

    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function(){
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}', [ContactController::class, 'show'])->name('show');
        Route::post('/', [ContactController::class, 'store'])->name('store');
        Route::delete('/{id}', [ContactController::class, 'delete'])->name('delete');
    });

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function() {
        Route::get('/', [RoleController::class, 'index'])->name('index')->middleware('permission:role_view');
        Route::get('/create', [RoleController::class, 'create'])->name('create')->middleware('permission:role_store');
        Route::post('/', [RoleController::class, 'store'])->name('store')->middleware('permission:role_store');
        Route::get('/{id}/edit', [RoleController::class, 'edit'])->name('edit')->middleware('permission:role_update');
        Route::patch('/{id}', [RoleController::class, 'update'])->name('update')->middleware('permission:role_update');
        Route::delete('/{id}', [RoleController::class, 'delete'])->name('delete')->middleware('permission:role_delete');
    });

    Route::group(['prefix' => 'staffs', 'as' => 'staffs.'], function() {
        Route::get('/', [StaffController::class, 'index'])->name('index')->middleware('permission:staff_view');
        Route::get('/create', [StaffController::class, 'create'])->name('create')->middleware('permission:staff_store');
        Route::post('/', [StaffController::class, 'store'])->name('store')->middleware('permission:staff_store');
        Route::get('/{id}/edit', [StaffController::class, 'edit'])->name('edit')->middleware('permission:staff_update');
        Route::patch('/{id}', [StaffController::class, 'update'])->name('update')->middleware('permission:staff_update');
        Route::delete('/{id}', [StaffController::class, 'delete'])->name('delete')->middleware('permission:staff_delete');
    });

    Route::group(['prefix' => 'upload-multiple-image', 'as' => 'upload.'], function() {
        Route::post('/', [UploadMultipleImage::class, 'store'])->name('store');
    });
});
