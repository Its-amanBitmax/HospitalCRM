<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\WardBedController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WelcomeController;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

Route::get('/', [WelcomeController::class, 'index']);

Route::get('/login', function () {
    return redirect()->route('admin.login.form');
})->name('login');

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
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
        Route::post('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('admin.profile.change-password');
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

        Route::get('/departments', [DepartmentController::class, 'index'])->name('admin.departments');
        Route::get('/get-departments', [DepartmentController::class, 'getDepartments'])->name('admin.get-departments');
        Route::post('/store-department', [DepartmentController::class, 'store'])->name('admin.store-department');
        Route::get('/department/{id}', [DepartmentController::class, 'show'])->name('admin.show-department');
        Route::put('/update-department/{id}', [DepartmentController::class, 'update'])->name('admin.update-department');
        Route::delete('/delete-department/{id}', [DepartmentController::class, 'destroy'])->name('admin.delete-department');

        Route::get('/registered-users', [AdminController::class, 'registeredUsers'])->name('admin.registered-users');
        Route::get('/get-registered-users', [AdminController::class, 'getRegisteredUsers'])->name('admin.get-registered-users');
        Route::post('/add-registered-user', [AdminController::class, 'addRegisteredUser'])->name('admin.add-registered-user');
        Route::post('/update-registered-user/{id}', [AdminController::class, 'updateRegisteredUser'])->name('admin.update-registered-user');
        Route::delete('/delete-registered-user/{id}', [AdminController::class, 'deleteRegisteredUser'])->name('admin.delete-registered-user');

        Route::get('/ipd-patients', [AdminController::class, 'ipdPatients'])->name('admin.ipd-patients');
        Route::get('/get-ipd-patients', [AdminController::class, 'getIpdPatients'])->name('admin.get-ipd-patients');
        Route::put('/update-ipd-patient/{id}', [AdminController::class, 'updateIpdPatient'])->name('admin.update-ipd-patient');
        Route::delete('/delete-ipd-patient/{id}', [AdminController::class, 'deleteIpdPatient'])->name('admin.delete-ipd-patient');

        Route::get('/opd-patients', [AdminController::class, 'opdPatients'])->name('admin.opd-patients');
        Route::get('/get-opd-patients', [AdminController::class, 'getOpdPatients'])->name('admin.get-opd-patients');
        Route::put('/update-opd-patient/{id}', [AdminController::class, 'updateOpdPatient'])->name('admin.update-opd-patient');
        Route::delete('/delete-opd-patient/{id}', [AdminController::class, 'deleteOpdPatient'])->name('admin.delete-opd-patient');

        Route::get('/discharged-patients', [AdminController::class, 'dischargedPatients'])->name('admin.discharged-patients');
        Route::get('/get-discharged-patients', [AdminController::class, 'getDischargedPatients'])->name('admin.get-discharged-patients');
        Route::put('/update-discharged-patient/{id}', [AdminController::class, 'updateDischargedPatient'])->name('admin.update-discharged-patient');
        Route::delete('/delete-discharged-patient/{id}', [AdminController::class, 'deleteDischargedPatient'])->name('admin.delete-discharged-patient');

        Route::resource('employees', EmployeeController::class)->names([
            'index' => 'admin.employees.index',
            'create' => 'admin.employees.create',
            'store' => 'admin.employees.store',
            'show' => 'admin.employees.show',
            'edit' => 'admin.employees.edit',
            'update' => 'admin.employees.update',
            'destroy' => 'admin.employees.destroy',
        ]);
    });
});
