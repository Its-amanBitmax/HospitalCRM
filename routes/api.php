<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\Api\SkillController;

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
Route::middleware('auth:sanctum')->put('/update-profile', [UserController::class, 'updateProfile']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);
Route::post('/check-user', [UserController::class, 'checkUserExists']);
Route::post('/update-credentials', [UserController::class, 'updateCredentials']);
Route::get('/banners', [BannerController::class, 'getBanners']);
Route::get('/skills', [SkillController::class, 'index']);
Route::get('/doctors', [SkillController::class, 'getDoctors']);