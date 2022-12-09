<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductTypeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// register & login
Route::controller(AuthController::class)->group(function(){
    Route::post('auth/member/register', 'member_register');
    Route::post('auth/member/login', 'member_login');
    Route::post('auth/admin/register', 'admin_register');
    Route::post('auth/admin/login', 'admin_login');
});

// member
Route::group(['middleware' => ['auth:sanctum', 'ability:member']], function() {
    Route::get('auth/member/me', [AuthController::class, 'member_me']);
    Route::post('auth/member/logout', [AuthController::class, 'member_logout']);
});

// admin
Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function() {
    Route::get('auth/admin/me', [AuthController::class, 'admin_me']);
    Route::post('auth/admin/logout', [AuthController::class, 'admin_logout']);

    Route::controller(MemberController::class)->prefix('member')->group(function () {
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/update', 'update');
        Route::post('/active', 'active');
        Route::post('/delete', 'delete');
    });

    Route::controller(ProductTypeController::class)->prefix('product_type')->group(function () {
        Route::post('/store', 'store');
        Route::post('/detail', 'detail');
        Route::post('/update', 'update');
        Route::post('/delete', 'delete');
    });
});
