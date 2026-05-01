<?php
// routes/web.php

use App\Http\Controllers\{
    DashboardController,
    ProductController,
    CartController,
    TransactionController,
    Auth\AuthController
};
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (All Users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (User)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products (Browse)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/{productId}', [CartController::class, 'update'])->name('update');
        Route::delete('/{productId}', [CartController::class, 'remove'])->name('remove');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::get('/count', [CartController::class, 'count'])->name('count');
    });

    // Transactions
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::get('/checkout', [TransactionController::class, 'checkout'])->name('checkout');
        Route::post('/process', [TransactionController::class, 'process'])->name('process');
        Route::get('/{invoiceNumber}', [TransactionController::class, 'show'])->name('show');
        Route::get('/{invoiceNumber}/print', [TransactionController::class, 'print'])->name('print');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products Management
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::get('/products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/stock', [AdminProductController::class, 'updateStock'])->name('products.update-stock');

    // Categories Management
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);

    // Transactions Management
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])->name('transactions.show');
    Route::patch('/transactions/{transaction}/status', [AdminTransactionController::class, 'updateStatus'])->name('transactions.update-status');
    Route::get('/transactions/export', [AdminTransactionController::class, 'export'])->name('transactions.export');

    // Users Management
    Route::resource('users', AdminUserController::class);
});

/*
|--------------------------------------------------------------------------
| Fallback Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
