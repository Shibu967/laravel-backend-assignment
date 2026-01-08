<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductImportController;

Route::get('/', function () {
    return view('welcome');
});

//  ==================== CUSTOMER ROUTES ====================
Route::prefix('customer')->name('customer.')->middleware('auth:web')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//  ==================== Admin ROUTES ====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

    Route::middleware('auth:admin')->group(function () {      
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        Route::resource('products', ProductController::class);
        Route::get(
            'products-datatable',
            [ProductController::class, 'datatable']
        )->name('products.datatable');
        Route::get('categories', [CategoryController::class, 'index'])
            ->name('categories.index');

        Route::post('products/import', [ProductImportController::class, 'import'])
            ->name('products.import');

        Route::get('import-status/{id}', [ProductImportController::class, 'status'])->name('products.import.status');
    });
});

require __DIR__ . '/auth.php';
