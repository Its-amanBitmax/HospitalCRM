<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DoctorLoginController;
use App\Http\Controllers\Api\RelativeController;
use App\Http\Controllers\Api\TestAndCheckupController;
use App\Http\Controllers\Api\HospitalScheduleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and assigned the "api" middleware group.
| 
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->get('/profile', [UserController::class, 'getProfile']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/skills', [SkillController::class, 'index']);
Route::middleware('auth:sanctum')->post('/update-profile', [UserController::class, 'updateProfile']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);
Route::post('/check-user', [UserController::class, 'checkUserExists']);
Route::post('/update-credentials', [UserController::class, 'updateCredentials']);
Route::get('/banners', [BannerController::class, 'getBanners']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/doctors', [SkillController::class, 'getDoctors']);
Route::middleware('auth:sanctum')->get('/organization', [AdminController::class, 'getOrganizationDetails']);
Route::get('/doctors/{doctor}/availability', [SkillController::class, 'getAvailability']);
Route::middleware('auth:sanctum')->prefix('appointments')->group(function () {
    Route::post('/book', [AppointmentController::class, 'bookAppointment']);
    Route::get('/user', [AppointmentController::class, 'getUserAppointments']);
    Route::post('/cancel/{appointment_id}', [AppointmentController::class, 'cancelAppointment']);
});
Route::middleware('auth:sanctum')->prefix('relatives')->group(function () {
    Route::post('/add', [RelativeController::class, 'store']);
    Route::get('/', [RelativeController::class, 'index']);
    Route::get('/{relative_id}', [RelativeController::class, 'show']);
    Route::post('/{relative_id}', [RelativeController::class, 'update']);
    Route::delete('/{relative_id}', [RelativeController::class, 'destroy']);
});
Route::post('/doctor/login', [DoctorLoginController::class, 'login']);
Route::middleware('auth:sanctum')->post('/doctor/logout', [DoctorLoginController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/doctor/profile', [DoctorLoginController::class, 'getProfile']);
Route::middleware('auth:sanctum')->post('/doctor/profile/update', [DoctorLoginController::class, 'updateProfile']);

Route::middleware('auth:sanctum')->get('/doctor/appointments-consultations', [DoctorLoginController::class, 'getAppointmentsAndConsultations']);
Route::middleware('auth:sanctum')->post('/doctor/update-appointment-status', [DoctorLoginController::class, 'updateAppointmentStatus']);
Route::middleware('auth:sanctum')->get('/schedules/today', [\App\Http\Controllers\Api\ScheduleController::class, 'getTodaySchedules']);

Route::middleware('auth:sanctum')->get('/doctor/today/task', [DoctorLoginController::class, 'doctor_today_task']);


Route::middleware('auth:sanctum')->post('/test/booking', [TestAndCheckupController::class, 'test_booking']);

Route::middleware('auth:sanctum')->get('/users/booking/list', [TestAndCheckupController::class, 'Userbookings']);

Route::get('/test/checkups', [TestAndCheckupController::class, 'get_all_testcheckup']);
Route::get('/hospital/schedules', [HospitalScheduleController::class, 'index']);