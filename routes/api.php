<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::controller(AuthController::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::get('/get-roles', 'getRoles');
    Route::post('/logout', 'logout');
});

// Protected routes
Route::group(['middleware' => 'auth:sanctum'], function() {
    // Check token if not expired and get authenticated user
    Route::controller(AuthController::class)->group(function() {
        Route::get('/check-user', 'checkUser');
    });
    
    
    // Category Routes
    Route::controller(CategoryController::class)
    ->prefix('categories')
    ->group(function() {
        Route::get('/all', 'getAll');
    });
    
    // Images Routes
    Route::controller(ImageController::class)
    ->prefix('images')
    ->group(function() {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::post('/increase-download-count/{image}', 'increaseDownloadCount');
    });
});
