<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WardBedController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BannerController;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    // Forgot password routes
    Route::post('/forgot-password', [AdminController::class, 'sendOTP'])->name('admin.send.otp');
    Route::post('/verify-otp', [AdminController::class, 'verifyOTP'])->name('admin.verify.otp');
    Route::post('/reset-password', [AdminController::class, 'resetPassword'])->name('admin.reset.password');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/ward-bed', [WardBedController::class, 'index'])->name('admin.ward-bed');
        Route::post('/ward-bed/store-ward', [WardBedController::class, 'storeWard'])->name('admin.store-ward');
        Route::post('/ward-bed/store-bed', [WardBedController::class, 'storeBed'])->name('admin.store-bed');
        Route::get('/ward-bed/get-wards', [WardBedController::class, 'getWards'])->name('admin.get-wards');
        Route::get('/ward-bed/get-beds', [WardBedController::class, 'getBeds'])->name('admin.get-beds');
        Route::put('/ward-bed/update-ward/{id}', [WardBedController::class, 'updateWard'])->name('admin.update-ward');
        Route::delete('/ward-bed/delete-ward/{id}', [WardBedController::class, 'deleteWard'])->name('admin.delete-ward');
        Route::put('/ward-bed/update-bed/{id}', [WardBedController::class, 'updateBed'])->name('admin.update-bed');
        Route::delete('/ward-bed/delete-bed/{id}', [WardBedController::class, 'deleteBed'])->name('admin.delete-bed');

        Route::get('/stock', [StockController::class, 'index'])->name('admin.stock');
        Route::post('/stock/store-supplier', [StockController::class, 'storeSupplier'])->name('admin.store-supplier');
        Route::post('/stock/store-item', [StockController::class, 'storeItem'])->name('admin.store-item');
        Route::get('/stock/get-suppliers', [StockController::class, 'getSuppliers'])->name('admin.get-suppliers');
        Route::get('/stock/get-items', [StockController::class, 'getItems'])->name('admin.get-items');
        Route::put('/stock/update-supplier/{id}', [StockController::class, 'updateSupplier'])->name('admin.update-supplier');
        Route::delete('/stock/delete-supplier/{id}', [StockController::class, 'deleteSupplier'])->name('admin.delete-supplier');
        Route::put('/stock/update-item/{id}', [StockController::class, 'updateItem'])->name('admin.update-item');
        Route::delete('/stock/delete-item/{id}', [StockController::class, 'deleteItem'])->name('admin.delete-item');

        Route::get('/faq', [FaqController::class, 'index'])->name('admin.faq');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('admin.store-faq');
        Route::get('/faq/get-faqs', [FaqController::class, 'getFaqs'])->name('admin.get-faqs');
        Route::put('/faq/update/{id}', [FaqController::class, 'update'])->name('admin.update-faq');
        Route::delete('/faq/delete/{id}', [FaqController::class, 'delete'])->name('admin.delete-faq');

        Route::get('/banner', [BannerController::class, 'index'])->name('admin.banner');
        Route::post('/banner/store', [BannerController::class, 'store'])->name('admin.store-banner');
        Route::get('/banner/get-banners', [BannerController::class, 'getBanners'])->name('admin.get-banners');
        Route::put('/banner/update/{id}', [BannerController::class, 'update'])->name('admin.update-banner');
        Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('admin.delete-banner');
    });
});
