<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Employee\EmployeeAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Employee\EmployeeDashboardController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Guest Routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/search', [ProductController::class, 'search'])->name('product.search');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Customer Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/order/{id}', [CustomerController::class, 'orderDetails'])->name('customer.order.details');
    Route::post('/order/cancel/{id}', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::post('/order/return/{id}', [OrderController::class, 'returnRequest'])->name('order.return');
    Route::post('/feedback', [CustomerController::class, 'submitFeedback'])->name('feedback.submit');
});

// Admin Auth Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('products', \App\Http\Controllers\Admin\ProductManagementController::class);
        Route::get('/employees', [AdminDashboardController::class, 'employees'])->name('admin.employees');
        Route::post('/employees', [AdminDashboardController::class, 'storeEmployee'])->name('admin.employees.store');
        Route::get('/orders', [AdminDashboardController::class, 'orders'])->name('admin.orders');
        Route::get('/feedback', [AdminDashboardController::class, 'feedback'])->name('admin.feedback');
    });
});

// Employee Auth Routes
Route::prefix('employee')->group(function () {
    Route::get('/login', [EmployeeAuthController::class, 'showLogin'])->name('employee.login');
    Route::post('/login', [EmployeeAuthController::class, 'login']);
    Route::post('/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');

    Route::middleware(['auth:employee'])->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'index'])->name('employee.dashboard');
        Route::get('/change-password', [EmployeeDashboardController::class, 'showChangePassword'])->name('employee.password');
        Route::post('/change-password', [EmployeeDashboardController::class, 'updatePassword']);
        Route::post('/order/update-status/{id}', [EmployeeDashboardController::class, 'updateOrderStatus'])->name('employee.order.update');
    });
});
